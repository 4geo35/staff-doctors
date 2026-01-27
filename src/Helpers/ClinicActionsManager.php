<?php

namespace GIS\StaffDoctors\Helpers;

use GIS\ContactPage\Interfaces\ContactInterface;
use GIS\StaffDoctors\Interfaces\ClinicInterface;
use GIS\StaffDoctors\Models\Clinic;
use Illuminate\Database\Eloquent\Collection;

class ClinicActionsManager
{
    public function setValuesFromContact(ClinicInterface $clinic): void
    {
        if (! $clinic->contact_id) { return; }
        $contact = $clinic->contact;
        if (! $contact) { return; }

        $clinic->name = $contact->title;

        list($city, $address) = $this->getCityFromAddress($contact->address);
        $clinic->address = $address;
        if (! empty($city)) { $clinic->city = $city; }

        $phone = $this->getPhone($contact);
        if (! empty($phone)) { $clinic->phone = $phone; }

        $email = $this->getEmail($contact);
        if (! empty($email)) { $clinic->email = $email; }
    }

    public function findClinicsByContactId(int $contactId): Collection
    {
        $modelClass = config("staff-doctors.customClinicModel") ?? Clinic::class;
        return $modelClass::query()
            ->with("contact")
            ->where("contact_id", "=", $contactId)
            ->get();
    }

    protected function getPhone(ContactInterface $contact): ?string
    {
        $phone = $contact->phones()->first();
        if (! $phone) { return null; }
        return $phone->value;
    }

    protected function getEmail(ContactInterface $contact): ?string
    {
        $email = $contact->emails()->first();
        if (! $email) { return null; }
        return $email->value;
    }

    protected function getCityFromAddress(string $address): array
    {
        if (empty($address)) { return [null, $address]; }
        $exploded = explode(',', $address);
        if (count($exploded) <= 1) { return [null, $address]; }

        $city = null;
        $forImplode = [];
        foreach ($exploded as $item) {
            if (str_starts_with($item, 'г.')) {
                $city = $item;
            } else {
                $forImplode[] = $item;
            }
        }
        return [$city, implode(", ", $forImplode)];
    }
}
