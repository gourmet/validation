<?php
namespace Gourmet\Validation\Validation;

use Cake\Utility\Inflector;
use Exception;
use Gourmet\Validation\Error\UnsupportedMethodException;

/**
 * A Proxy class used to remove any extra arguments when the user intended to call
 * a method in another class that is not aware of validation providers signature
 */
class IsoCodesProvider
{
    /**
     * The namespace of the class/object to proxy.
     *
     * @var mixed
     */
    protected $_namespace;

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
     * Constructor, sets the default class to use for calling methods
     *
     * @param string $namespace The default namespace to proxy.
     */
    public function __construct($namespace = '\IsoCodes')
    {
        $this->_namespace = $namespace;
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
        $class = $this->_namespace . '\\' . Inflector::classify($method);

        if (!class_exists($class)) {
            throw new Exception('Undefined iso codes validation method');
        }

        $context = array_pop($arguments);

        if (!is_array($context) || array_keys($context) === $this->_contextKeys) {
            array_push($arguments, $context);
        }

        return call_user_func_array([$class, 'validate'], $arguments);
    }
}
