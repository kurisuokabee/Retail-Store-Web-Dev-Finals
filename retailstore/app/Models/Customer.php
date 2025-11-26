<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'customer_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'date_of_birth',
        'phone',
        'address',
    ];

    /**
     * Return the password for the auth system.
     * Laravel expects getAuthPassword() to return the hashed password.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Provide a compatibility `id` attribute so existing views can use `$customer->id`.
     */
    public function getIdAttribute()
    {
        return $this->customer_id;
    }
}
