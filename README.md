**This is a draft. Don't use in production**

# kiwi-suite/config

kiwi-suite/config is a php array config parser/accessor

[![Build Status](https://travis-ci.org/kiwi-suite/config.svg?branch=master)](https://travis-ci.org/kiwi-suite/config)
[![Coverage Status](https://coveralls.io/repos/github/kiwi-suite/config/badge.svg?branch=develop)](https://coveralls.io/github/kiwi-suite/config?branch=develop)
[![Packagist](https://img.shields.io/packagist/v/kiwi-suite/config.svg)](https://packagist.org/packages/kiwi-suite/config)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/kiwi-suite/config.svg)](https://packagist.org/packages/kiwi-suite/config)
[![Packagist](https://img.shields.io/packagist/l/kiwi-suite/config.svg)](https://packagist.org/packages/kiwi-suite/config)

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require kiwi-suite/config
```

### Example

```php
$config = new Config([
    'db' => [
        'user' => "myuser",
        'host' => "myhost",
        'pass' => "mypass",
    ]
]);
$config->get('db.user');

```

## License

kiwi-suite/config is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) - see the `LICENSE` file for details
