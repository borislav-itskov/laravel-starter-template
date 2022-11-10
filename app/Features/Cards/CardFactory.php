<?php

namespace App\Features\Cards;

use App\Services\CardService;
use App\Validators\CardValidator;

abstract class CardFactory
{
    protected CardService $cardService;
    protected CardValidator $validator;

    public function __construct()
    {
        $this->cardService = app(CardService::class);
        $this->validator = app(CardValidator::class);
    }
}