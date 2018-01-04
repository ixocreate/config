<?php
/**
 * kiwi-suite/config (https://github.com/kiwi-suite/config)
 *
 * @package kiwi-suite/config
 * @see https://github.com/kiwi-suite/config
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\Config\Bootstrap;

use KiwiSuite\Application\ApplicationConfig;
use KiwiSuite\Application\Bootstrap\BootstrapInterface;
use KiwiSuite\Application\Bootstrap\BootstrapRegistry;
use KiwiSuite\Config\Config;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Glob;

final class ConfigBootstrap implements BootstrapInterface
{

    /**
     * @param ServiceManagerConfigurator $serviceManagerConfigurator
     * @codeCoverageIgnore
     */
    public function configureServiceManager(ServiceManagerConfigurator $serviceManagerConfigurator): void
    {
    }

    /**
     * @param ApplicationConfig $applicationConfig
     * @param BootstrapRegistry $bootstrapRegistry
     */
    public function bootstrap(ApplicationConfig $applicationConfig, BootstrapRegistry $bootstrapRegistry): void
    {
        $mergedConfig = [];
        foreach ($applicationConfig->getModules() as $module) {
            if (empty($module->getDefaultConfig())) {
                continue;
            }
            $mergedConfig = ArrayUtils::merge($mergedConfig, $module->getDefaultConfig());
        }

        $configDirectories = [
            $applicationConfig->getConfigDirectory(),
        ];
        foreach ($applicationConfig->getBundles() as $bundle) {
            $configDirectories[] = $bundle->getConfigDirectory();
        }
        $configDirectories[] = $applicationConfig->getConfigDirectory() . 'local/';
        foreach ($configDirectories as $directory) {
            if (!\is_dir($directory)) {
                continue;
            }
            foreach (Glob::glob($directory . "*.config.php", Glob::GLOB_BRACE, true) as $file) {
                $data = require $file;
                if (!\is_array($data)) {
                    continue;
                }
                $prefix = \mb_substr(\basename($file), 0, -11);
                $data = [$prefix => $data];
                $mergedConfig = ArrayUtils::merge($mergedConfig, $data);
            }
        }
        $bootstrapRegistry->addService(Config::class, new Config($mergedConfig));
    }
}
