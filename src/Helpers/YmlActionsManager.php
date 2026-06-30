<?php

namespace GIS\StaffDoctors\Helpers;

use GIS\StaffDoctors\Facades\OfferActions;
use GIS\StaffDoctors\Interfaces\ClinicInterface;
use GIS\StaffDoctors\Interfaces\DoctorCertificateInterface;
use GIS\StaffDoctors\Interfaces\DoctorEducationInterface;
use GIS\StaffDoctors\Interfaces\DoctorJobInterface;
use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Interfaces\DoctorServiceInterface;
use GIS\StaffDoctors\Models\Clinic;
use GIS\StaffDoctors\Models\DoctorService;
use GIS\StaffPages\Interfaces\EmployeeInterface;
use GIS\StaffPages\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use SimpleXMLElement;
class YmlActionsManager
{
    protected SimpleXMLElement|null $file = null;
    public function getXMLContent(): string|null
    {
        $key = config("staff-doctors.ymlCacheKey");
        $lifetime = config("staff-doctors.ymlCacheLifetime");

        return Cache::remember($key, $lifetime, function () {
            $this->initFile();
            if (! $this->file) { return null; }

            $this->addDoctors();
            $this->addClinics();
            $this->addServices();
            $this->addOffers();

            return $this->file->asXML();
        });
    }

    protected function initFile(): void
    {
        $this->file = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' ?><shop></shop>");
        $this->file->addAttribute("date", now()->format('Y-m-d H:i'));
        $this->file->addAttribute("version", "2.0");

        $this->file->addChild("name", config("staff-doctors.ymlName"));
        $this->file->addChild("company", config("staff-doctors.ymlCompany"));
        $this->file->addChild("url", config("app.url"));

        $picture = config("staff-doctors.ymlPicture");
        if (file_exists(public_path($picture))) {
            $this->file->addChild("picture", asset($picture));
        }

        $email = config("staff-doctors.ymlEmail");
        if (! empty($email)) {
            $this->file->addChild("email", $email);
        }
    }

    protected function addDoctors(): void
    {
        $collection = $this->getDoctorCollection();
        if (! $collection->count()) { return; }

        $doctors = $this->file->addChild("doctors");
        foreach ($collection as $item) {
            $this->addDoctor($doctors, $item);
        }
    }

    protected function getDoctorCollection(): Collection
    {
        $modelClass = config("staff-pages.customEmployeeModel") ?? Employee::class;
        $query = $modelClass::query()
            ->with(["activeDepartments", "doctorInfo"]);

        $query->whereNotNull("published_at")
            ->whereHas("doctorInfo", fn ($q) => $q->whereNotNull("published_at"));

        return $query->orderBy("last_name")->get();
    }

    protected function addDoctor(SimpleXMLElement $doctors, EmployeeInterface $employee): void
    {
        $doctor = $doctors->addChild("doctor");
        $doctor->addAttribute("id", trim($employee->slug));
        $doctor->addChild("name", trim($employee->fio));
        $doctor->addChild("url", route("web.employees.doctor", ["employee" => $employee]));
        $doctor->addChild("internal_id", $employee->id);
        $doctor->addChild("first_name", trim($employee->name));
        $doctor->addChild("surname", trim($employee->last_name));
        if (! empty($employee->patronymic)) {
            $doctor->addChild("patronymic", trim($employee->patronymic));
        }
        if (! empty($employee->image)) {
            $url = route("thumb-img", ["template" => "doctor-yml", "filename" => $employee->image->filename]);
            $doctor->addChild("picture", $url);
        }

        $this->addDoctorInfo($doctor, $employee);
        $this->addDoctorEducations($doctor, $employee);
        $this->addDoctorJobs($doctor, $employee);
        $this->addCertificates($doctor, $employee);
    }

    protected function addDoctorInfo(SimpleXMLElement $doctor, EmployeeInterface $employee): void
    {
        $info = $employee->doctorInfo;
        if (empty($info)) { return; }

        if (! empty($info->experience_years)) {
            $doctor->addChild("experience_years", trim($info->experience_years));
        }
        if (! empty($info->career_start_date)) {
            $doctor->addChild("career_start_date", trim($info->career_start_date));
        }
        if (! empty($info->degree)) {
            $doctor->addChild("degree", trim($info->degree));
        }
        if (! empty($info->rank)) {
            $doctor->addChild("rank", trim($info->rank));
        }
        if (! empty($info->category)) {
            $doctor->addChild("category", trim($info->category));
        }
    }

    protected function addDoctorEducations(SimpleXMLElement $doctor, EmployeeInterface $employee): void
    {
        $info = $employee->doctorInfo;
        if (empty($info)) { return; }
        $collection = $info->orderedEducation;
        if (! $collection->count()) { return; }

        foreach ($collection as $item) {
            $this->addDoctorEducation($doctor, $item);
        }
    }

    protected function addDoctorEducation(SimpleXMLElement $doctor, DoctorEducationInterface $education): void
    {
        $element = $doctor->addChild("education");
        if (! empty($education->organization)) {
            $element->addChild("organization", trim($education->organization));
        }
        if (! empty($education->finish_year)) {
            $element->addChild("finish_year", trim($education->finish_year));
        }
        if (! empty($education->type)) {
            $element->addChild("type", trim($education->type));
        }
        if (! empty($education->specialization)) {
            $element->addChild("specialization", trim($education->specialization));
        }
    }

    protected function addDoctorJobs(SimpleXMLElement $doctor, EmployeeInterface $employee): void
    {
        $info = $employee->doctorInfo;
        if (empty($info)) { return; }
        $collection = $info->orderedJobs;
        if (! $collection->count()) { return; }

        foreach ($collection as $item) {
            $this->addDoctorJob($doctor, $item);
        }
    }

    protected function addDoctorJob(SimpleXMLElement $doctor, DoctorJobInterface $job): void
    {
        $element = $doctor->addChild("job");
        if (! empty($job->organization)) {
            $element->addChild("organization", trim($job->organization));
        }
        if (! empty($job->period_years)) {
            $element->addChild("period_years", trim($job->period_years));
        }
        if (! empty($job->position)) {
            $element->addChild("position", trim($job->position));
        }
    }

    protected function addCertificates(SimpleXMLElement $doctor, EmployeeInterface $employee): void
    {
        $info = $employee->doctorInfo;
        if (empty($info)) { return; }
        $collection = $info->orderedCertificates;
        if (! $collection->count()) { return; }

        foreach ($collection as $item) {
            $this->addDoctorCertificate($doctor, $item);
        }
    }

    protected function addDoctorCertificate(SimpleXMLElement $doctor, DoctorCertificateInterface $certificate): void
    {
        $element = $doctor->addChild("certificate");
        if (! empty($certificate->organization)) {
            $element->addChild("organization", trim($certificate->organization));
        }
        if (! empty($certificate->finish_year)) {
            $element->addChild("finish_year", trim($certificate->finish_year));
        }
        if (! empty($certificate->name)) {
            $element->addChild("name", trim($certificate->name));
        }
    }

    protected function addClinics(): void
    {
        $collection = $this->getClinicCollection();
        if (! $collection->count()) { return; }

        $clinics = $this->file->addChild("clinics");
        foreach ($collection as $item) {
            $this->addClinic($clinics, $item);
        }
    }

    protected function getClinicCollection(): Collection
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        return $modelClass::query()
            ->orderBy("name")
            ->get();
    }

    protected function addClinic(SimpleXMLElement $clinics, ClinicInterface $clinic): void
    {
        $element = $clinics->addChild("clinic");
        $element->addAttribute("id", $clinic->feed_id);
        $element->addChild("internal_id", $clinic->id);
        if (! empty($clinic->name)) {
            $element->addChild("name", trim($clinic->name));
        }
        if (! empty($clinic->address)) {
            $element->addChild("address", trim($clinic->address));
        }
        if (! empty($clinic->city)) {
            $element->addChild("city", trim($clinic->city));
        }
        if (! empty($clinic->email)) {
            $element->addChild("email", trim($clinic->email));
        }
        if (! empty($clinic->phone)) {
            $element->addChild("phone", trim($clinic->phone));
        }
        if (! empty($clinic->company_id)) {
            $element->addChild("company_id", trim($clinic->company_id));
        }
    }

    protected function addServices(): void
    {
        $collection = $this->getServiceCollection();
        if (! $collection->count()) { return; }

        $services = $this->file->addChild("services");
        foreach ($collection as $item) {
            $this->addService($services, $item);
        }
    }

    protected function getServiceCollection(): Collection
    {
        $modelClass = config("staff-doctors.customDoctorServiceModel") ?? DoctorService::class;
        return $modelClass::query()
            ->orderBy("title")
            ->get();
    }

    protected function addService(SimpleXMLElement $services, DoctorServiceInterface $service): void
    {
        $element = $services->addChild("service");
        $element->addAttribute("id", $service->slug);
        $element->addChild("internal_id", $service->id);
        if (! empty($service->title)) {
            $element->addChild("name", trim($service->title));
        }
        if (! empty($service->gov_id)) {
            $element->addChild("gov_id", trim($service->gov_id));
        }
        if (! empty($service->short)) {
            $element->addChild("description", trim($service->short));
        }
    }

    protected function addOffers(): void
    {
        $collection = OfferActions::getOnlyActive();
        if (! $collection->count()) { return; }

        $offers = $this->file->addChild("offers");
        foreach ($collection as $item) {
            $this->addOffer($offers, $item);
        }
    }

    protected function addOffer(SimpleXMLElement $offers, DoctorOfferInterface $offer): void
    {
        $element = $offers->addChild("offer");
        $element->addAttribute("id", $offer->feed_id);
//        $element->addChild("internal_id", $offer->id);
        $element->addChild(
            "url",
            htmlspecialchars($offer->feed_url, ENT_XML1 | ENT_QUOTES, 'UTF-8')
        );

        $element->addChild("oms", $offer->oms ? 'true' : 'false');
        $element->addChild("appointment", $offer->appointment ? 'true' : 'false');

        $this->addOfferPrice($element, $offer);
        $this->addOfferService($element, $offer);
        $this->addOfferClinic($element, $offer);
    }

    protected function addOfferPrice(SimpleXMLElement $element, DoctorOfferInterface $offer): void
    {
        $priceModel = $offer->active_price;
        if (! $priceModel) { return; }
        $price = $element->addChild("price");
        $price->addChild("base_price", trim($priceModel->price));
        $price->addChild("currency", "RUB");
        if ($priceModel->discount) {
            $discount = $price->addChild("discount", trim($priceModel->discount));
            if ($priceModel->discount_condition) {
                $discount->addAttribute("name", trim($priceModel->discount_condition));
            }
        }
        if ($priceModel->free_condition) {
            $price->addChild("free_appointment", trim($priceModel->free_condition));
        }
    }

    protected function addOfferService(SimpleXMLElement $element, DoctorOfferInterface $offer): void
    {
        $offerService = $offer->service;
        if (! $offerService) { return; }

        $serviceElement = $element->addChild("service");
        $serviceElement->addAttribute("id", $offerService->slug);
    }

    protected function addOfferClinic(SimpleXMLElement $element, DoctorOfferInterface $offer): void
    {
        $offerClinic = $offer->clinic;
        if (! $offerClinic) { return; }

        $clinicElement = $element->addChild("clinic");
        $clinicElement->addAttribute("id", trim($offerClinic->feed_id));

        $this->addOfferDoctor($clinicElement, $offer);
    }

    protected function addOfferDoctor(SimpleXMLElement $element, DoctorOfferInterface $offer): void
    {
        $offerDoctor = $offer->doctor;
        if (! $offerDoctor) { return; }

        $doctorElement = $element->addChild("doctor");
        $doctorElement->addAttribute("id", trim($offerDoctor->slug));

        $offerSpeciality = $offer->department;
        if ($offerSpeciality) {
            $doctorElement->addChild("speciality", trim($offerSpeciality->title));
        }

        $doctorElement->addChild("children_appointment", $offer->children ? 'true' : 'false');
        $doctorElement->addChild("adult_appointment", $offer->adult ? 'true' : 'false');
        $doctorElement->addChild("house_call", $offer->house_call ? 'true' : 'false');
        $doctorElement->addChild("telemed", $offer->telemedicine ? 'true' : 'false');
        $doctorElement->addChild("is_base_service", $offer->is_base_service ? 'true' : 'false');
    }
}
