<?php
namespace Gourmet\Validation\Validation;

use Exception;
use Gourmet\Validation\Error\UnsupportedMethodException;

/**
 * A Proxy class used to remove any extra arguments when the user intended to call
 * a method in another class that is not aware of validation providers signature
 */
class RespectProvider
{
    /**
     * The class/object to proxy.
     *
     * @var mixed
     */
    protected $_class;

    /**
     * Context array keys.
     *
     * @var array
     */
    protected $_contextKeys = [
        'data',
        'providers',
        'newRecord',
    ];

    /**
     * Unsupported methods that will throw an exception.
     *
     * @var array
     */
    protected $_unsupportedMethods = [
        'allOf',
        'attribute',
        'bank',
        'bankAccount',
        'bic',
        'call',
        'each',
        'key',
        'noneOf',
        'oneOf',
    ];

    /**
     * Constructor, sets the default class to use for calling methods
     *
     * @param string $class The default class to proxy.
     */
    public function __construct($class = '\Respect\Validation\Validator')
    {
        $this->_class = $class;
    }

    /**
     * Proxies validation method calls to the Respect\Validation\Validator class.
     *
     * The last argument (context) will be sliced off for all methods since they
     * are unaware of it.
     *
     * @param string $method The validation method to call.
     * @param array $arguments The list of arguments to pass to the method.
     * @return bool Whether or not the validation rule passed.
     */
    public function __call($method, $arguments)
    {
        if (!is_callable($method, $this->_class)) {
            throw new Exception('Undefined respect validation method');
        }

        if (in_array($method, $this->_unsupportedMethods)) {
            throw new UnsupportedMethodException([$method]);
        }

        $check = array_shift($arguments);
        $context = array_pop($arguments);

        if (!is_array($context) || array_keys($context) === $this->_contextKeys) {
            array_push($arguments, $context);
        }

        return call_user_func_array([$this->_class, $method], $arguments)->validate($check);
    }
}
