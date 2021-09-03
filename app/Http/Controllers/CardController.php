<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Services\CardService;
use App\Services\TrapService;
use App\Services\SpellService;
use App\Services\MonsterService;
use App\Validators\CardValidator;
use App\Features\Cards\CardDirector;

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
     * Update a card route
     *
     * @method PATCH
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function patchFactory(
        Card $card,
        Request $request,
        CardDirector $cardDirector
    )
    {
        $cardBuilder = $cardDirector->getFactory($card->type);
        $data = $cardBuilder->validateUpdate($card, $request);
        return $cardBuilder->update($card, $data);
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    /////////////////                 IF STATEMENTS PART                   ///////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

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

    /**
     * Update a card route
     *
     * @method PATCH
     * @param int $id
     * @return Illuminate\Support\Facades\Redirect
     */
    public function patchIfStatements(
        Card $card,
        Request $request,
        CardService $cardService,
        CardValidator $validator
    )
    {
        $data = $validator->validateUpdate($request, $card->type);
        $card = $cardService->update($card, $data);

        switch ($card->type) {
            case 'Spell':
                $spellService = app(SpellService::class);
                $spellService->update($card->spell, $data);
                break;

            case 'Trap':
                $trapService = app(TrapService::class);
                $trapService->update($card->trap, $data);
                break;

            case 'Monster':
                $monsterService = app(MonsterService::class);
                $monsterService->update($card->monster, $data);
                break;

            default:
                throw new \Exception("Undefined card type", 1);
                break;
        }

        return $card;
    }
}
