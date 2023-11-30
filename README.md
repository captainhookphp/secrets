# CaptainHook Secrets

[![Latest Stable Version](https://poser.pugx.org/captainhook/secrets/v/stable.svg?v=1)](https://packagist.org/packages/captainhook/secrets)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/captainhook/secrets.svg?v1)](https://packagist.org/packages/captainhook/captainhook)
[![License](https://poser.pugx.org/captainhook/secrets/license.svg?v=1)](https://packagist.org/packages/captainhook/secrets)
[![Build Status](https://github.com/captainhookphp/secrets/workflows/continuous-integration/badge.svg)](https://github.com/captainhookphp/secrets/actions)
[![Twitter](https://img.shields.io/badge/Twitter-%40captainhookphp-blue.svg)](https://twitter.com/intent/user?screen_name=captainhookphp)

This package is used to detect passwords in your code. Mainly to prevent you from committing them to your version control.

You can use the regular expressions provided by the classes under `Regex\Supplier` or make use of the included `Detector` class.
You can easily create your own `Supplier` classes or open a pull-request if you think it would be useful to others.

Here are some usage examples:

Using `Suppliers`
```php
$result = Detector::create()
         ->useSuppliers(
            Aws::class,
            Google::class,
            GitHub::class
        )->detectIn($myString)

if ($result->wasSecretDetected()) {
    echo "secret detected: " . implode(' ', $result->matches());
}
```

Using your custom regex
```php
$result = Detector::create()
        ->useRegex('#password = "\\S"#i')
        ->detectIn($myString)

if ($result->wasSecretDetected()) {
    echo "secret detected: " . implode(' ', $result->matches());
}
```

The `Detector` also supports a white list
```php
$result = Detector::create()
        ->useRegex('#password = "\\S"#i')
        ->allow('#root#')
        ->detectIn($myString)

if ($result->wasSecretDetected()) {
    echo "secret detected: " . implode(' ', $result->matches());
}
```
