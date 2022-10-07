<?php

namespace UMA\Assignment\Validator\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class NameException extends ValidationException
{
    public static $defaultTemplates = [
      self::MODE_DEFAULT => [
          self::STANDARD => 'name is already taken.',
      ],
    ];

}
