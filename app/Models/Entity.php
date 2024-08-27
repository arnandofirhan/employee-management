<?php

namespace App\Models;

use App\Traits\ActorTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use UuidTrait, ActorTrait, SoftDeletes;

    protected $guarded = [];

    public function userSetting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function entityCategories(): BelongsToMany
    {
        return $this->belongsToMany(EntityCategory::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function employeeStatus(): BelongsTo
    {
        return $this->belongsTo(EmployeeStatus::class);
    }
}
