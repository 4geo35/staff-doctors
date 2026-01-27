<?php

namespace GIS\StaffDoctors\Listeners;

use GIS\ContactPage\Events\ContactUpdated;
use GIS\StaffDoctors\Facades\ClinicActions;
use Illuminate\Contracts\Queue\ShouldQueue;

class FreshClinicAfterContactUpdate implements ShouldQueue
{
    public function __construct() {}

    public function handle(ContactUpdated $event): void
    {
        $contact = $event->contact;
        $collection = ClinicActions::findClinicsByContactId($contact->id);
        foreach ($collection as $clinic) {
            ClinicActions::setValuesFromContact($clinic);
            $clinic->save();
        }
    }
}
