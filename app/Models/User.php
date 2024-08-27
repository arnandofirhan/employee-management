<?php

namespace App\Models;

use App\Traits\ActorTrait;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use UuidTrait, ActorTrait, SoftDeletes, HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'full_image_url'
    ];

    public function getFullImageUrlAttribute(): string
    {
        if ($this->image_url && Storage::disk('public')->exists($this->image_url)) {
            return asset('storage/' . $this->image_url);
        }

        preg_match_all('/[A-Z]+/i', $this->full_name, $matches);
        if (count($matches) && count($matches[0])) {
            $fullName = [];
            foreach ($matches[0] as $name) {
                if (strlen($name) > 3) {
                    $fullName[] = $name;
                }
            }

            if (count($fullName)) {
                $fullName = implode('+', $fullName);

                return 'https://ui-avatars.com/api/?size=160&background=random&font-size=0.35&name=' . $fullName;
            }
        }

        return 'https://api.dicebear.com/7.x/avataaars/svg?randomizeIds=false';
    }

    public function userSetting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }
}
