<?php

namespace App\Features\Cards;

class SpellCard extends BaseCard implements Cardable
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

    /**
     * Return an array of form fields needed to
     * build the card creation form
     *
     * @return arra
     */
    public function getFormFields(): array
    {
        $fields = parent::getFormFields();
        $fields[] = 'effect';
        return $fields;
    }
}