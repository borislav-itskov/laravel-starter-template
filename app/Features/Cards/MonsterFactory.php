<?php

namespace App\Features\Cards;

use App\Models\Card;
use App\Services\MonsterService;

class MonsterFactory extends CardFactory implements CardableFactory
{
    /**
     * @var App\Services\MonsterService
     */
    private $monsterService;

    public function __construct()
    {
        parent::__construct();
        $this->monsterService = app(MonsterService::class);
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
        $this->monsterService->create($data);

        // return it
        return $card;
    }
}