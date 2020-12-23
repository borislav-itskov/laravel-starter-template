<?php

namespace App\Features\Cards;

use App\Models\Card;
use App\Services\SpellService;

class SpellFactory extends CardFactory implements CardableFactory
{
    /**
     * @var App\Services\SpellService
     */
    private $spellService;

    public function __construct()
    {
        parent::__construct();
        $this->spellService = app(SpellService::class);
    }

    /**
     * Describe how to create a card.
     *
     * @return 
     */
    public function create(array $data): Card
    {
        // create the card
        $card = $this->cardService->create($data);

        // create it's monster data
        $data['card_id'] = $card->id;
        $this->spellService->create($data);

        // return it
        return $card;
    }
}