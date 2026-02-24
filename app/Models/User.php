<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\VendorsRequest;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'phone',
        'avatar',
        'status',
        'date_of_birth',
        'place_of_residence',
        'gender',
        'remember_token'
    ];


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }



    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }




    public function addresses()
    {
        return $this->hasMany(Address::class);
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }


    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }


    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
    public function vendorsRequests()
    {
        return $this->hasMany(VendorsRequest::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
