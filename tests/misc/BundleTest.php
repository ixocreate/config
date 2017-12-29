<?php
/**
 * kiwi-suite/config (https://github.com/kiwi-suite/config)
 *
 * @package kiwi-suite/config
 * @see https://github.com/kiwi-suite/config
 * @copyright Copyright (c) 2010 - 2017 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuiteMisc\Config;

use KiwiSuite\Application\Bundle\BundleInterface;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

class BundleTest implements BundleInterface
{

    /**
     * @param ServiceManagerConfigurator $serviceManagerConfigurator
     */
    public function configureServiceManager(ServiceManagerConfigurator $serviceManagerConfigurator): void
    {
    }

    /**
     * @return string
     */
    public function getConfigDirectory(): string
    {
        return "test";
    }

    /**
     * @return string
     */
    public function getBootstrapDirectory(): string
    {
        return "";
    }
}
