# Validation

[![Build Status](https://travis-ci.org/gourmet/validation.svg?branch=master)](https://travis-ci.org/gourmet/validation)
[![Total Downloads](https://poser.pugx.org/gourmet/validation/downloads.svg)](https://packagist.org/packages/gourmet/validation)
[![License](https://poser.pugx.org/gourmet/validation/license.svg)](https://packagist.org/packages/gourmet/validation)

Extra validation providers and rules for [CakePHP 3]

## Install

Using [Composer]:

```
composer require gourmet/validation:dev-master
```

This plugin does not require to be loaded in bootstrap as it only uses autoloaded classes.

## Usage

In any table's `validationDefault()` method:

```php
public function validationDefault(Validator $validator)
{
    $validator
        ->provider('respect', new \Gourmet\Validation\Validation\RespectProvider())
        ->provider('iso', new \Gourmet\Validation\Validation\IsoCodesProvider())

        ->add('country_code', 'valid', [
            'provider' => 'respect',
            'rule' => 'countryCode',
        ])

        ->add('zip_code_by_country_code', 'valid', [
            'rule' => function($value, $context) {
                $provider = $context['providers']['respect'];
                $country = $context['data']['country_code'];
                return $provider->__call('postalCode', [$value, $country]);
            }
        ])

        ->add('zip_code_by_country', 'valid', [
            'rule' => function($value, $context) {
                $provider = $context['providers']['iso'];
                $country = $context['data']['country'];
                return $provider->__call('zip_code', [$value, $country]);
            }
        ])

        ->add('book_code', 'valid', [
            'provider' => 'iso',
            'rule' => 'isbn10'
        ])
}
```

For more, check out the supported validation methods for each of the official libraries the providers
proxy:

- [Respect\Validation][respect]
- [IsoCodes][isocodes]

## Patches & Features

* Fork
* Mod, fix
* Test - this is important, so it's not unintentionally broken
* Commit - do not mess with license, todo, version, etc. (if you do change any, bump them into commits of
their own that I can ignore when I pull)
* Pull request - bonus point for topic branches

## Bugs & Feedback

http://github.com/gourmet/validation/issues

## License

Copyright (c) 2015, Jad Bitar and licensed under [The MIT License][mit].

[CakePHP 3]:http://cakephp.org
[Composer]:http://getcomposer.org
[mit]:http://www.opensource.org/licenses/mit-license.php
[respect]:http://respect.li/Validation
[isocodes]:https://github.com/ronanguilloux/IsoCodes
