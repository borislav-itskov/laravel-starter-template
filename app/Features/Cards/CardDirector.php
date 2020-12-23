<?php

namespace App\Features\Cards;

use App\Models\Card;

class CardDirector
{
    /**
     * Create a card
     *
     * @param  array  $data
     * @return Card
     */
    public function getBuilder(string $type): CardableBuilder
    {
        switch ($type) {
            case 'Spell':
                return app(SpellBuilder::class);
                break;

            case 'Trap':
                return app(TrapBuilder::class);
                break;

            case 'Monster':
                return app(MonsterBuilder::class);
                break;
            
            default:
                throw new \Exception("Undefined card type", 1);
                break;
        }
    }
}