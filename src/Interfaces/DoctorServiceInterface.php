<?php

namespace GIS\StaffDoctors\Interfaces;

use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;
use ArrayAccess;
use JsonSerializable;
use Stringable;

interface DoctorServiceInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString,
    HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable
{

}
