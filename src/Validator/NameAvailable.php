<?php

namespace UMA\Assignment\Validator;

use Respect\Validation\Rules\AbstractRule;

class NameAvailable extends AbstractRule
{
    public function validate($input): bool
    {
        return false;
    }

}
