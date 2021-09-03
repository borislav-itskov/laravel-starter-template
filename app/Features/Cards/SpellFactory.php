<?php

namespace App\Features\Cards;

use App\Models\Card;
use App\Services\SpellService;
use Illuminate\Http\Request;

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
     * Describe how to validate a spell card.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateCreate(Request $request): array
    {
        $this->validator->addSharedRules();
        $this->validator->addTypeRules();
        $this->validator->addSpellRules();
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
        $this->spellService->create($data);
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
        $this->spellService->update($card->spell, $data);
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
        $this->validator->addSpellRules();
        $this->validator->leaveOnlyForUpdate($request);
        return $this->validator->execute($request);
    }
}