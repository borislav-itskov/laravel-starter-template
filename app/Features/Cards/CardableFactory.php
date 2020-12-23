<?php

namespace App\Features\Cards;

use App\Models\Card;

interface CardableFactory
{
    /**
     * Describe how to create a card.
     *
     * @return 
     */
    public function create(array $data): Card;
}