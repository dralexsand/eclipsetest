<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MethodRule implements Rule
{

    protected array $values;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->values = $this->availableValues();
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
        return $this->values;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    private function availableValues()
    {
        return [
            'add',
            'replace'
        ];
    }

}
