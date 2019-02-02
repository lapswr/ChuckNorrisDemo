<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Emails implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $emails = explode(",", $value);
        foreach ($emails as $email) {
            if (isset($email) && $email !== "") {
                $temp_email = trim($email);
                if (!filter_var($temp_email, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
            }
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
        return 'Please provide a valid emails list.';
    }
}
