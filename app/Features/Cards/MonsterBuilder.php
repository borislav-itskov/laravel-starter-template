<?php

namespace App\Features\Cards;

use App\Models\Card;
use App\Services\CardService;
use App\Services\MonsterService;

class MonsterBuilder implements CardableBuilder
{
    /**
     * @var App\Services\CardService
     */
    private $cardService;

    /**
     * @var App\Services\MonsterService
     */
    private $monsterService;

    public function __construct(CardService $cardService, MonsterService $monsterService)
    {
        $this->cardService = $cardService;
        $this->monsterService = $monsterService;
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
        $this->monsterService->create($data);

        // return it
        return $card;
    }
}