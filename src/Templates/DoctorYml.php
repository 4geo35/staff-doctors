<?php

namespace GIS\StaffDoctors\Templates;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class DoctorYml implements ModifierInterface
{
    public function apply(ImageInterface $image): ImageInterface
    {
        return $image->cover(210, 210);
    }
}
