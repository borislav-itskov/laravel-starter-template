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
        $this->validator->addTypeRules();
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
        $card = $this->cardService->create($data);
        $data['card_id'] = $card->id;
        $this->trapService->create($data);
        return $card;
    }

    /**
     * Describe how to update a card.
     *
     * @param Card $card
     * @param array $data
     * @return Card
     */
    public function update(Card $card, array $data): Card
    {
        $card = $this->cardService->update($card, $data);
        $this->trapService->update($card->trap, $data);
        return $card;
    }

    /**
     * Describe how to validate update of a card.
     *
     * @param Card $card
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateUpdate(Card $card, Request $request): array
    {
        $this->validator->addSharedRules();
        $this->validator->addTrapRules();
        $this->validator->leaveOnlyForUpdate($request);
        return $this->validator->execute($request);
    }
}