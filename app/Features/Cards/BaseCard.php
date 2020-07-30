<?php

namespace App\Features\Cards;

abstract class BaseCard
{
    /**
     * Return an array of form fields needed to
     * build the card creation form
     *
     * @return arra
     */
    public function getFormFields(): array
    {
        return ['name'];
    }
}