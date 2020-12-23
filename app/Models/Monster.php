<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['card_id', 'effect', 'attack_points', 'defence_points'];
}
