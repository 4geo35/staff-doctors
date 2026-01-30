<?php

namespace GIS\StaffDoctors\Livewire\Admin\DoctorOfferPrices;

use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\StaffDoctors\Interfaces\DoctorOfferPriceInterface;
use GIS\StaffDoctors\Models\DoctorOfferPrice;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public DoctorOfferInterface $offer;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $priceId = null;

    public float|null $price = null;
    public float|null $discount = null;
    public string $discountCondition = "";
    public string $freeCondition = "";

    public function rules(): array
    {
        return [
            "price" => ["required", "numeric"],
            "discount" => ["nullable", "numeric"],
            "discountCondition" => ["nullable", "string", "max:255"],
            "freeCondition" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "price" => "Цена",
            "discount" => "Скидка",
            "discountCondition" => "Условия получения скидки",
            "freeCondition" => "Условия бесплатного приема",
        ];
    }

    public function render(): View
    {
        $query = $this->offer->prices();
        $query->orderBy("price");
        $prices = $query->get();
        return view("sd::livewire.admin.doctor-offer-prices.list-wire", compact("prices"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth()) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth()) { return; }
        $this->validate();

        $this->offer->prices()->create([
            "price" => $this->price,
            "discount" => empty($this->discount) ? null : $this->discount,
            "discount_condition" => $this->discountCondition,
            "free_condition" => $this->freeCondition,
        ]);

        session()->flash("doctor-offer-prices-success", "Цена успешно добавлена");
        $this->closeData();
    }

    public function showEdit(int $modelId): void
    {
        $this->resetFields();
        $this->priceId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }

        $this->price = $modelObject->price;
        $this->discount = $modelObject->discount;
        $this->discountCondition = $modelObject->discount_condition;
        $this->freeCondition = $modelObject->free_condition;

        $this->displayData = true;
    }

    public function update(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }
        $this->validate();

        $modelObject->update([
            "price" => $this->price,
            "discount" => $this->discount,
            "discount_condition" => $this->discountCondition,
            "free_condition" => $this->freeCondition,
        ]);

        session()->flash("doctor-offer-prices-success", "Цена успешно обновлена");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $modelId): void
    {
        $this->resetFields();
        $this->priceId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }

        try {
            $modelObject->delete();
        } catch (\Exception $exception) {
            session()->flash("doctor-offer-prices-error", "Ошибка при удалении цены");
            $this->closeDelete();
            return;
        }

        session()->flash("doctor-offer-prices-success", "Цена успешно удалена");
        $this->closeDelete();
    }

    public function switchPublish(int $modelId): void
    {
        $this->resetFields();
        $this->priceId = $modelId;
        $modelObject = $this->findModel();
        if (! $modelObject) { return; }
        if (! $this->checkAuth()) { return; }
        // Может быть активна только одна цена
        if (! $modelObject->published_at) {
            foreach ($this->offer->prices()->whereNotNull("published_at")->get() as $price) {
                $price->update(["published_at" => null]);
            }
        }
        $modelObject->update([
            "published_at" => $modelObject->published_at ? null : now(),
        ]);
    }

    protected function resetFields(): void
    {
        $this->reset("price", "discount", "discountCondition", "freeCondition", "priceId");
    }

    protected function checkAuth(): bool
    {
        try {
            $this->authorize("update", $this->offer);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("doctor-offer-prices-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?DoctorOfferPriceInterface
    {
        $modelClass = config("staff-doctors.customDoctorOfferPriceModel") ?? DoctorOfferPrice::class;
        $modelObject = $modelClass::find($this->priceId);
        if (! $modelObject) {
            session()->flash("doctor-offer-prices-error", "Цена не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $modelObject;
    }
}
