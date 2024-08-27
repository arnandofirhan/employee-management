<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Spatie\Permission\Models\Role as SpatieRoles;

class Role extends SpatieRoles
{
    use UuidTrait;
}
