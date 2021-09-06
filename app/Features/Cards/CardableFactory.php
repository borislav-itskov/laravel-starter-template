<?php

namespace App\Features\Cards;

use App\Models\Card;
use Illuminate\Http\Request;

interface CardableFactory
{
    /**
     * Describe how to create a card.
     *
     * @param array $data
     * @return Card
     */
    public function create(array $data): Card;

    /**
     * Describe how to validate creation of a card.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateCreate(Request $request): array;

    /**
     * Describe how to update a card.
     *
     * @param Card $card
     * @param array $data
     * @return Card
     */
    public function update(Card $card, array $data): Card;

    /**
     * Describe how to validate update of a card.
     *
     * @param Card $card
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function validateUpdate(Card $card, Request $request): array;

    // FOR TYPE CHANGE

    /**
     * Describe how to validate the change of the type of a card.
     *
     * @param Card $card
     * @param Request $request
     * @return array
     */
    public function validateTypeChange(Card $card, Request $request): array;

    /**
     * Describe actions after the type of a card has been changed.
     *
     * @param Card $card
     * @return Card
     */
    public function quit(Card $card): Card;

    /**
     * Describe how to update a card when it's type has changed.
     *
     * @param Card $card
     * @return Card
     */
    public function updateType(Card $card, array $data): Card;
}