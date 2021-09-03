<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'name'];

    /**
     * Get the spell data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function spell(): HasOne
    {
        return $this->hasOne(Spell::class);
    }

    /**
     * Get the spell data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trap(): HasOne
    {
        return $this->hasOne(Trap::class);
    }

    /**
     * Get the spell data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function monster(): HasOne
    {
        return $this->hasOne(Monster::class);
    }
}
