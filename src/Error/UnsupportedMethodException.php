<?php

namespace Gourmet\Validation\Error;

use Cake\Core\Exception\Exception;

class UnsupportedMethodException extends Exception
{
    protected $_messageTemplate = 'Call to unsupported method [%s]';
}
