<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CardService;
use App\Services\TrapService;
use App\Services\SpellService;
use App\Services\MonsterService;
use App\Features\Cards\CardDirector;

class CardController extends Controller
{
    /**
     * Create a card route
     *
     * @method POST
     * @return Illuminate\Support\Facades\Redirect
     */
    public function storeFactory(Request $request, CardDirector $cardDirector)
    {
        $data = $request->all();
        $cardBuilder = $cardDirector->getFactory($data['type']);
        return $cardBuilder->create($data);
    }

    /**
     * Create a card route
     *
     * @method POST
     * @return Illuminate\Support\Facades\Redirect
     */
    public function storeIfStatements(
        Request $request,
        CardService $cardService
    )
    {
        $data = $request->all();
        $card = $cardService->create($data);
        $data['card_id'] = $card->id;

        switch ($card->type) {
            case 'Spell':
                $spellService = app(SpellService::class);
                $spellService->create($data);
                break;

            case 'Trap':
                $trapService = app(TrapService::class);
                $trapService->create($data);
                break;

            case 'Monster':
                $monsterService = app(MonsterService::class);
                $monsterService->create($data);
                break;

            default:
                throw new \Exception("Undefined card type", 1);
                break;
        }

        return $card;
    }
}
