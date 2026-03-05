<?php

namespace GIS\StaffDoctors\Helpers;

use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
class YmlActionsManager
{
    protected SimpleXMLElement|null $file = null;
    public function getXMLContent(): string|null
    {
        // TODO make cache

        $this->initFile();
        if (! $this->file) { return null; }

        $this->addDoctors();

        return $this->file->asXML();
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
        $doctors = $this->file->addChild("doctors");
    }
}
