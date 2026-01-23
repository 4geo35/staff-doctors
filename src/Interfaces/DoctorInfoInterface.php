<?php

namespace GIS\StaffDoctors\Interfaces;

use ArrayAccess;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JsonSerializable;
use Stringable;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;

interface DoctorInfoInterface extends Arrayable, ArrayAccess, CanBeEscapedWhenCastToString,
    HasBroadcastChannel, Jsonable, JsonSerializable, QueueableEntity, Stringable, UrlRoutable
{
    public function employee(): BelongsTo;
    public function education(): HasMany;
    public function orderedEducation(): HasMany;
    public function jobs(): HasMany;
    public function certificates(): HasMany;
    public function orderedCertificates(): HasMany;
}
