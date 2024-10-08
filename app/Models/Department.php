<?php

namespace App\Models;

use App\Traits\ActorTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use UuidTrait, ActorTrait, SoftDeletes;

    protected $guarded = [];

    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class);
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }
}
