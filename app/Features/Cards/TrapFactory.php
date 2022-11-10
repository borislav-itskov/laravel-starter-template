<?php

namespace App\Features\Cards;

use App\Models\Card;
use Illuminate\Http\Request;
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
     * Describe how to validate a trap card.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateCreate(Request $request): array
    {
        $this->validator->addSharedRules();
        $this->validator->addTrapRules();
        return $this->validator->execute($request);
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