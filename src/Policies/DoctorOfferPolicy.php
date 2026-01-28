<?php

namespace GIS\StaffDoctors\Policies;

use App\Models\User;
use GIS\StaffDoctors\Interfaces\DoctorOfferInterface;
use GIS\UserManagement\Facades\PermissionActions;
use GIS\UserManagement\Interfaces\PolicyPermissionInterface;

class DoctorOfferPolicy implements PolicyPermissionInterface
{
    const PERMISSION_KEY = "doctor_offers";
    const VIEW_ALL = 2;
    const CREATE = 4;
    const UPDATE = 8;
    const DELETE = 16;

    public static function getPermissions(): array
    {
        return [
            self::VIEW_ALL => "Просмотр всех",
            self::CREATE => "Создание",
            self::UPDATE => "Обновление",
            self::DELETE => "Удаление",
        ];
    }

    public static function getDefaults(): int
    {
        return self::VIEW_ALL + self::CREATE + self::UPDATE + self::DELETE;
    }

    public function viewAny(User $user): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::VIEW_ALL);
    }

    public function create(User $user): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::CREATE);
    }

    public function update(User $user, DoctorOfferInterface $offer): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::UPDATE);
    }

    public function delete(User $user, DoctorOfferInterface $offer): bool
    {
        return PermissionActions::allowedAction($user, self::PERMISSION_KEY, self::DELETE);
    }
}
