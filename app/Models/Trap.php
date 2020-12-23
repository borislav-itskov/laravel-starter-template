<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trap extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['card_id', 'effect', 'trigger'];
}