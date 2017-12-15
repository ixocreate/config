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
namespace KiwiSuiteTest\Config\Bootstrap;

use KiwiSuite\Application\ApplicationConfig;
use KiwiSuite\Application\Bootstrap\BootstrapRegistry;
use KiwiSuite\Config\Bootstrap\ConfigBootstrap;
use KiwiSuite\Config\Config;
use KiwiSuiteMisc\Config\ModuleTest;
use PHPUnit\Framework\TestCase;

class ConfigBootstrapTest extends TestCase
{
    /**
     * @var ApplicationConfig
     */
    private $applicationConfig;

    public function setUp()
    {
        $this->applicationConfig = new ApplicationConfig(
            true,
            __DIR__ . '/../../config',
            __DIR__ . '/../../bootstrap'
        );
    }

    public function testBootstrap()
    {
        $configBootstrap = new ConfigBootstrap();

        $bootstrapRegistry = new BootstrapRegistry([]);

        $configBootstrap->bootstrap($this->applicationConfig, $bootstrapRegistry);

        $this->assertArrayHasKey(Config::class, $bootstrapRegistry->getServices());
        $this->assertInstanceOf(Config::class, $bootstrapRegistry->getServices()[Config::class]);

        /** @var Config $config */
        $config = $bootstrapRegistry->getService(Config::class);
        $this->assertTrue($config->has("db"));
        $this->assertSame("mynewpass", $config->get("db.pass"));
        $this->assertSame("myuser", $config->get("db.user"));
        $this->assertSame("myhost", $config->get("db.host"));
    }

    public function testMissingDirectory()
    {
        $applicationConfig = new ApplicationConfig(
            true,
            __DIR__ . '/../../config',
            __DIR__ . '/../../bootstrap',
            null,
            null,
            null,
            [ModuleTest::class]
        );

        $bootstrapRegistry = new BootstrapRegistry($applicationConfig->getModules());

        $configBootstrap = new ConfigBootstrap();
        $configBootstrap->bootstrap($applicationConfig, $bootstrapRegistry);

        $this->assertArrayHasKey(Config::class, $bootstrapRegistry->getServices());
        $this->assertInstanceOf(Config::class, $bootstrapRegistry->getServices()[Config::class]);
        /** @var Config $config */
        $config = $bootstrapRegistry->getService(Config::class);
        $this->assertSame([
            'db' => [
                'user' => "myuser",
                'host' => "myhost",
                'pass' => "mynewpass",
            ],
        ], $config->all());
    }
}
