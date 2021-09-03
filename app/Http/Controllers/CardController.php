<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CardService;
use App\Services\TrapService;
use App\Services\SpellService;
use App\Services\MonsterService;
use App\Features\Cards\CardDirector;
use App\Validators\CardValidator;

class CardController extends Controller
{
    /**
     * Create a card route
     *
     * @method POST
     * @return Illuminate\Support\Facades\Redirect
     */
    public function storeFactory(
        Request $request,
        CardDirector $cardDirector,
        CardValidator $validator
    )
    {
        $type = $validator->validateType($request);
        $cardBuilder = $cardDirector->getFactory($type);
        $data = $cardBuilder->validateCreate($request);
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
        CardService $cardService,
        CardValidator $validator
    )
    {
        $type = $validator->validateType($request);
        $data = $validator->validateCreate($request, $type);
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