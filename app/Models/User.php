<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->belongToMany(Idea::class, 'votes');
    }

    public function getAvatar()
    {
        $firstCharacter = $this->email[0];

        if (is_numeric($firstCharacter)) {
            $intToUse = ord($firstCharacter) - 21;
        }else{
            $intToUse = ord(strtolower($firstCharacter)) - 96;
        }
        

        return "https://gravatar.com/avatar/"
            .md5($this->email)
            ."?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-"
            .$intToUse
            .".png";
    }

    public function isAdmin()
    {
        return in_array($this->email, [
            'yekokooo1991@gmail.com',
            'admin@gmail.com'
        ]);
    }
}
