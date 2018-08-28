<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Hash;

/**
 * Class Storekeeper
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class Storekeeper extends Authenticatable
{
    use Notifiable;
    use HasRolesAndAbilities;

    protected $fillable = ['name', 'pin', 'password', 'remember_token'];
    
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function dispositions()
    {
        return $this->hasMany('App\Disposition', 'stock_id');
    }

    public function dispositionsDriver()
    {
        return $this->hasMany('App\Disposition', 'driver_id');
    }
    
    
    
}
