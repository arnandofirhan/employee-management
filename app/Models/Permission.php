<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use UuidTrait;
}
