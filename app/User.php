<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use \DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'image', 'verified', 'fcm_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['image_path', 'friends'];


    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }


    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function getImagePathAttribute()
    {
        return Storage::disk('public_uploads')->url('user_images/' . $this->image);
        //return asset('uploads/user_images/'.$this->image);
    }

    public function chatsReseviedTotal()
    {
        return $this->hasMany(ChatsRealtime::class, 'sender_id', 'id')->where('receiver_id', auth()->user()->id)->where('read', '!=', '2');
    }
    public function getFriendsAttribute()
    {
        return User::pluck('id');
    }
}