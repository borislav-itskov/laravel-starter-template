<?php

namespace App\Features\Cards;

use App\Services\CardService;

abstract class CardFactory
{
    protected CardService $cardService;

    public function __construct()
    {
        $this->cardService = app(CardService::class);
    }
}