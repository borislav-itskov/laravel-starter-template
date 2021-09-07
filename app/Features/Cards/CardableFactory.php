<?php

namespace App\Features\Cards;

use App\Models\Card;
use Illuminate\Http\Request;

interface CardableFactory
{
    /**
     * Describe how to create a card.
     *
     * @param array $data
     * @return Card
     */
    public function create(array $data): Card;
}