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
    public function getFactory(string $type): CardableFactory
    {
        switch ($type) {
            case 'Spell':
                return app(SpellFactory::class);
                break;

            case 'Trap':
                return app(TrapFactory::class);
                break;

            case 'Monster':
                return app(MonsterFactory::class);
                break;
            
            default:
                throw new \Exception("Undefined card type", 1);
                break;
        }
    }
}