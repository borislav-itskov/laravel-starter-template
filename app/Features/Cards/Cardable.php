<?php

namespace App\Features\Cards;

interface Cardable
{
    /**
     * Get the colour of the card
     *
     * @return string
     */
    public function getColour(): string;
}