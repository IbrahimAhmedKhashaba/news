<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'admin_id');
    }

    public function authorization()
    {
        return $this->belongsTo(Authorization::class, 'authorization_id');
    }

    public function hasAccess($config_permission)
    {
        $authorization = $this->authorization;
        
        if (!$authorization) {
            return false;
        }
 
        foreach ($authorization->permissions as $permission) {
            
            if ($permission == $config_permission ?? false) {
                return true;
            }
        }
    }

    public function receivesBroadcastNotificationsOn(): string{
        return 'admins.'.$this->id;
    }
}
