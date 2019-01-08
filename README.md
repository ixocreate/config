# IXOCREATE config

[![Build Status](https://travis-ci.com/ixocreate/config.svg?branch=master)](https://travis-ci.com/ixocreate/config)
[![Coverage Status](https://coveralls.io/repos/github/ixocreate/config/badge.svg?branch=master)](https://coveralls.io/github/ixocreate/config?branch=master)
[![Packagist](https://img.shields.io/packagist/v/ixocreate/config.svg)](https://packagist.org/packages/ixocreate/config)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/ixocreate/config.svg)](https://packagist.org/packages/ixocreate/config)
[![Packagist](https://img.shields.io/packagist/l/ixocreate/config.svg)](https://packagist.org/packages/ixocreate/config)

ixocreate/config is a php array config parser/accessor

## Installation

Install the package via composer:

```sh
composer require ixocreate/config
```

## Usage

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

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
