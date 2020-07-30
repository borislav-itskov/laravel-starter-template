<?php

namespace App\Features\Cards;

class SpellCard implements Cardable
{
    /**
     * Get the colour of the card
     *
     * @return string
     */
    public function getColour(): string
    {
        return 'green';
    }
}