<?php

namespace UMA\Assignment\Validator;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;

//    public function validate($request, array $rules)
//    {
//        foreach ($rules as $filed => $rule) {
//            try {
//                $rule->setName(ucfirst($filed))->assrt($request->getParam($filed));
//            } catch (NestedValidationException $exception) {
//                $this->errors[$filed] = $exception->getMessages();
//            }
//        }
//        $_SESSION['errors'] = $this->errors;
//
//        return $this;
//    }

}
