<?php

namespace App\Rules;

use App\Services\GamePlayService;
use Illuminate\Contracts\Validation\Rule;

class ValidCardSequence implements Rule
{
    //Valid cards for this game.
    private array $validCards = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K', 'A'];

    private GamePlayService $service;

    public function __construct()
    {
        $this->service = new GamePlayService();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validCards = $this->validCards;

        // Separate each card, apply uppercase and convert to collection
        $value = $this->service->sanitize($value);

        // Check if all sequence's cards are valid according to the valid cards Array
        $value->transform(function ($item, $key) use ($validCards) {
            return in_array($item, $validCards) == true ? $item : false;
        });

        if (in_array(false, $value->toArray())) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Wrong format. Please inform it accordingly. Valid options are: \'1, 2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A\'';
    }


}
