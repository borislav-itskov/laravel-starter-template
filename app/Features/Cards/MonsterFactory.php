<?php

namespace App\Features\Cards;

use App\Models\Card;
use Illuminate\Http\Request;
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
     * Describe how to validate a monster card.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateCreate(Request $request): array
    {
        $this->validator->addSharedRules();
        $this->validator->addTypeRules();
        $this->validator->addMonsterRules();
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
        $this->monsterService->create($data);
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
        $this->monsterService->update($card->monster, $data);
        return $card->refresh();
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
        $this->validator->addMonsterRules();
        $this->validator->leaveOnlyForUpdate($request);
        return $this->validator->execute($request);
    }

    /**
     * Describe how to validate the change of the type of a card.
     *
     * @param Card $card
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateTypeChange(Card $card, Request $request): array
    {
        $this->validator->addSharedRules();
        $this->validator->leaveOnlyForUpdate($request);
        $this->validator->addMonsterRules();
        return $this->validator->execute($request);
    }

    /**
     * Describe actions after the type of a card has been changed.
     *
     * @param Card $card
     * @return Card
     */
    public function quit(Card $card): Card
    {
        $this->monsterService->delete($card->monster);
        return $card->refresh();
    }

    /**
     * Describe how to update a card when it's type has changed.
     *
     * @param Card $card
     * @param array $data
     * @return Card
     */
    public function updateType(Card $card, array $data): Card
    {
        $card = $this->cardService->update($card, $data);
        $this->monsterService->create($data);
        return $card->refresh();
    }
}