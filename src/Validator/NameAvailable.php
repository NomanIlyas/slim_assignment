<?php

namespace Noman\Assignment\Validator;

use Respect\Validation\Rules\AbstractRule;

/*TODO validate name already exist or not*/
class NameAvailable extends AbstractRule
{
    public function validate($input): bool
    {
        return false;
    }

}
