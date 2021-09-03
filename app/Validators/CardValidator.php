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
     * Add the type rules when needed
     *
     * @return void
     */
    public function addTypeRules(): void
    {
        $this->rules = array_merge($this->rules, $this->getTypeRules());
    }

    /**
     * Add the shared rules to the global rules.
     *
     * @return void
     */
    public function addSharedRules(): void
    {
        $this->rules = array_merge(
            $this->rules,
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
     * Leave only the rules that exists in the request array
     *
     * @param Request $request
     * @return void
     */
    public function leaveOnlyForUpdate(Request $request): void
    {
        $this->rules = array_intersect_key(
            $this->rules,
            $request->all()
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
    private function getTypeRules(bool $update = false): array
    {
        $validType = ['Monster', 'Spell', 'Trap'];

        $isRequired = $update ? 'nullable' : 'required';

        return [
            'type' => [$isRequired, 'string', Rule::in($validType)]
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

    /**
     * Validate the card type and return it.
     *
     * @param Request $request
     * @return string|null
     */
    public function validateTypeUpdate(Request $request): ?string
    {
        $data = $request->validate($this->getTypeRules(true));

        return !empty($data) ? $data['type'] : null;
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    /////////////////                 IF STATEMENTS PART                   ///////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get the card validation rules.
     *
     * @param string $type
     * @return array
     */
    private function getValidationRulesAccordingToType(string $type): array
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

        return $rules;
    }

    /**
     * Validate the create of a card by if statements part
     *
     * @param Request $request
     * @param string $type
     * @return array
     */
    public function validateCreate(Request $request, string $type): array
    {
        $rules = $this->getValidationRulesAccordingToType($type);
        return $request->validate($rules);
    }

    /**
     * Validate the create of a card by if statements part
     *
     * @param Request $request
     * @param string $type
     * @return array
     */
    public function validateUpdate(Request $request, string $type): array
    {
        $rules = $this->getValidationRulesAccordingToType($type);
        return $request->validate($rules);
    }
}