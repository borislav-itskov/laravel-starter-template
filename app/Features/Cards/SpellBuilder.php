<?php

namespace App\Features\Cards;

use App\Models\Card;

class SpellBuilder implements CardableBuilder
{
    /**
     * Describe how to create a card.
     *
     * @return 
     */
    public function create(): Card
    {
        return new Card();
    }
}