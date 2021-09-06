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
        $newType = $validator->validateTypeUpdate($request);
        $oldType = $card->type;
        $cardType = !is_null($newType) ? $newType : $card->type;
        $hasChangeRequest = !is_null($newType) && $newType != $oldType;

        // set the validation according to the type request
        $data = $hasChangeRequest
            ? $validator->validateTypeChange($request, $cardType)
            : $validator->validateUpdate($request, $cardType)
        ;

        $card = $cardService->update($card, $data);
        $data['card_id'] = $card->id;

        // decl
        $spellService = app(SpellService::class);
        $trapService = app(TrapService::class);
        $monsterService = app(MonsterService::class);

        switch ($card->type) {
            case 'Spell':
                $spellCard = $card->spell;
                if ($spellCard) {
                    $spellService->update($card->spell, $data);
                } else {
                    $spellService->create($data);
                }
                break;

            case 'Trap':
                $trapCard = $card->trap;

                if ($trapCard) {
                    $trapService->update($trapCard, $data);
                } else {
                    $trapService->create($data);
                }
                break;

            case 'Monster':
                $monsterCard = $card->monster;

                if ($monsterCard) {
                    $monsterService->update($monsterCard, $data);
                } else {
                    $monsterService->create($data);
                }
                break;

            default:
                throw new \Exception("Undefined card type", 1);
                break;
        }

        // sync the data
        if ($hasChangeRequest) {
            switch ($oldType) {
                case 'Spell':
                    $spellService->delete($card->spell, $data);
                    break;

                case 'Trap':
                    $trapService->delete($card->trap, $data);
                    break;

                case 'Monster':
                    $monsterService->delete($card->monster, $data);
                    break;

                default:
                    throw new \Exception("Undefined card type", 1);
                    break;
            }
        }

        return $card->refresh();
    }
}
