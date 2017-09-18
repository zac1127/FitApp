<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*----------------------------------------
    *          Database Relationships
    *-----------------------------------------*/

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function points($id)
    {
        return Post::where('user_id', '=', $id)->sum('points');
    }

    public static function pointsThisWeek($id)
    {
        $week = Week::orderBy('created_at', 'asc')->get()->last();
        return Post::where('created_at', '>=', $week->created_at)->sum('points');
    }

    public function getPointsAttribute()
    {
        $points = Post::where('user_id', $this->attributes['id'])->sum('points');

        return $points;
    }


    public static function check_ec_auth($username, $password)
    {
        $return = false;

        $user_data = array(
            'username' => $username,
            'password' => $password,
        );

        $auth = file_get_contents('http://digitalmissioncontrol.com/is/authenticatedStaff/base64/?key=L6kvG5Mx9a&userdata='.base64_encode(json_encode($user_data)));

        $auth_data = json_decode($auth);

        if ($auth_data->auth == 'yes') {
            $return = true;
        }

        return $return;
    }
}
