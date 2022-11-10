<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CardValidator
{
    /**
     * The rules we're going to validate.
     *
     * @var array
     */
    private $rules = [];

    /**
     * Add the shared rules to the global rules.
     *
     * @return void
     */
    public function addSharedRules(): void
    {
        $this->rules = array_merge(
            $this->rules,
            $this->getTypeRules(),
            [
                'name' => ['required', 'string']
            ]
        );
    }

    /**
     * Add the trap card rules.
     *
     * @return void
     */
    public function addMonsterRules(): void
    {
        $this->rules = array_merge(
            $this->rules,
            [
                'effect' => ['nullable', 'string'],
                'attack_points' => ['required', 'integer'],
                'defence_points' => ['required', 'integer'],
            ]
        );
    }

    /**
     * Add the spell card rules.
     *
     * @return void
     */
    public function addSpellRules(): void
    {
        $this->rules = array_merge(
            $this->rules,
            [
                'effect' => ['required', 'string']
            ]
        );
    }

    /**
     * Add the trap card rules.
     *
     * @return void
     */
    public function addTrapRules(): void
    {
        $this->rules = array_merge(
            $this->rules,
            [
                'effect' => ['required', 'string'],
                'trigger' => ['required', 'string'],
            ]
        );
    }

    /**
     * Execute the validation.
     *
     * @param Request $request
     * @return array
     */
    public function execute(Request $request): array
    {
        return $request->validate($this->rules);
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    /////////////////                     SHARED PART                   //////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the type rules.
     *
     * @return array
     */
    private function getTypeRules(): array
    {
        $validType = ['Monster', 'Spell', 'Trap'];

        return [
            'type' => ['required', 'string', Rule::in($validType)]
        ];
    }

    /**
     * Validate the card type and return it.
     *
     * @param Request $request
     * @return string
     */
    public function validateType(Request $request): string
    {
        return $request->validate($this->getTypeRules())['type'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    /////////////////                 IF STATEMENTS PART                   ///////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Validate the create of a card by if statements part
     *
     * @param Request $request
     * @param string $type
     * @return array
     */
    public function validateCreate(Request $request, string $type): array
    {
        $rules = array_merge(
            $this->getTypeRules(),
            [
                'name' => ['required', 'string']
            ]
        );

        switch ($type) {
            case 'Spell':
                $rules['effect'] = ['required', 'string'];
                break;

            case 'Trap':
                $rules['effect'] = ['required', 'string'];
                $rules['trigger'] = ['required', 'string'];
                break;

            case 'Monster':
                $rules['effect'] = ['nullable', 'string'];
                $rules['attack_points'] = ['required', 'integer'];
                $rules['defence_points'] = ['required', 'integer'];
                break;

            default:
                throw new \Exception("Undefined card type", 1);
                break;
        }

        return $request->validate($rules);
    }
}