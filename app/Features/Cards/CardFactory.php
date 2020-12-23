<?php

namespace App\Features\Cards;

use App\Services\CardService;

abstract class CardFactory
{
    /**
     * @var App\Services\CardService
     */
    protected $cardService;

    public function __construct()
    {
        $this->cardService = app(CardService::class);
    }
}