<?php

namespace App\Http\Controllers\Concerns;

trait ValidatesContactNumbers
{
    protected function requiredContactNumberRules(): array
    {
        return ['required', 'string', 'regex:/^09\d{9}$/'];
    }

    protected function nullableContactNumberRules(): array
    {
        return ['nullable', 'string', 'regex:/^09\d{9}$/'];
    }

    protected function contactNumberMessages(array $fields): array
    {
        $messages = [];

        foreach ($fields as $field) {
            $messages[$field . '.regex'] = 'Contact number must be 11 digits and start with 09.';
        }

        return $messages;
    }
}
