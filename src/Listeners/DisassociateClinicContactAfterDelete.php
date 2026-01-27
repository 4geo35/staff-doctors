<?php

namespace GIS\StaffDoctors\Listeners;

use GIS\ContactPage\Events\ContactDeleted;
use GIS\StaffDoctors\Facades\ClinicActions;
use GIS\StaffDoctors\Interfaces\ClinicInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class DisassociateClinicContactAfterDelete implements ShouldQueue
{
    public function __construct() {}

    public function handle(ContactDeleted $event): void
    {
        $contactId = $event->contactId;
        $collection = ClinicActions::findClinicsByContactId($contactId);
        Log::info("DisassociateClinicContactAfterDelete listener " . $collection->count());
        foreach ($collection as $clinic) {
            /**
             * @var ClinicInterface $clinic
             */
            $clinic->contact()->disassociate();
            $clinic->save();
        }
    }
}
