<?php

namespace App\Features\Cards;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Features\Cards\CardDirector;

class CardTypeChangeHandler
{
    private CardDirector $cardDirector;

    public function __construct()
    {
        $this->cardDirector = app(CardDirector::class);
    }

    /**
     * Update the card from it's old type to the new.
     *
     * @param Card $card
     * @param Request $request
     * @return Card
     */
    public function handle(Card $card, Request $request): Card
    {
        // validate if we can make the change
        $newType = $request->get('type');
        $newTypeBuilder = $this->cardDirector->getFactory($newType);
        $data = $newTypeBuilder->validateTypeChange($card, $request);

        // stop being the previous type
        $currentTypeBuilder = $this->cardDirector->getFactory($card->type);
        $card = $currentTypeBuilder->quit($card);

        // start being the new type
        $data['card_id'] = $card->id;
        $card = $newTypeBuilder->updateType($card, $data);
        return $card->refresh();
    }
}