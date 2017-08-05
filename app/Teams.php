<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $fillable = [
        'team_name',
    ];

    /*----------------------------------------
    *          Database Relationships
    *-----------------------------------------*/

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*----------------------------------------
    *          Returns Teams Average
    *-----------------------------------------*/

    public function getAvgAttribute()
    {
        $member_count = User::where('teams_id', $this->attributes['id'])->count();

        if ($member_count == 0) {
            return 0;
        }

        $average = round($this->attributes['points'] / $member_count, 1);

        return $average;
    }
}
