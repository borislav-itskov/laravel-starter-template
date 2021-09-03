<?php

namespace App\Features\Cards;

use App\Models\Card;
use App\Services\TrapService;

class TrapFactory extends CardFactory implements CardableFactory
{
    /**
     * @var App\Services\TrapService
     */
    private $trapService;

    public function __construct()
    {
        parent::__construct();
        $this->trapService = app(TrapService::class);
    }

    /**
     * Describe how to create a card.
     *
     * @return Card
     */
    public function create(array $data): Card
    {
        // create the card
        $card = $this->cardService->create($data);

        // create it's monster data
        $data['card_id'] = $card->id;
        $this->trapService->create($data);

        // return it
        return $card;
    }
}