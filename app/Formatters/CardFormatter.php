<?php

namespace App\Formatters;

use App\Services\CardService;

class CardFormatter
{
    /**
     * @var App\Services\CardService
     */
    private $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Get the form fields needed to create a card.
     *
     * @param  array  $types
     * @return array
     */
    public function getFormFields(array $types): array
    {
        $fields = [];
        foreach ($types as $name => $class) {
            $fields[$name] = $this->getFormFieldsByClass($class);
        }

        return $fields;
    }

    /**
     * Get the form fields needed to create a card.
     *
     * @param  string  $class
     * @return array
     */
    public function getFormFieldsByClass(string $class): array
    {
        $card = $this->cardService->initCardable($class);
        return $card->getFormFields();
    }
}