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
     * Execute the validation.
     *
     * @param Request $request
     * @return array
     */
    public function execute(Request $request): array
    {
        return $request->validate($this->rules);
    }
}