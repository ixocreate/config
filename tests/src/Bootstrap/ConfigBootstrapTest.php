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
namespace KiwiSuiteTest\Config\Bootstrap;

use KiwiSuite\Application\ApplicationConfig;
use KiwiSuite\Application\Bootstrap\BootstrapRegistry;
use KiwiSuite\Config\Bootstrap\ConfigBootstrap;
use KiwiSuite\Config\Config;
use KiwiSuiteMisc\Config\BundleTest;
use KiwiSuiteMisc\Config\ModuleEmptyTest;
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
            __DIR__ . '/../../bootstrap',
            null,
            null,
            null,
            [ModuleTest::class, ModuleEmptyTest::class],
            [BundleTest::class]
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
        $this->assertSame("key1value", $config->get("somekey.key1"));
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
            [ModuleTest::class, ModuleEmptyTest::class],
            [BundleTest::class]
        );

        $bootstrapRegistry = new BootstrapRegistry($applicationConfig->getModules());

        $configBootstrap = new ConfigBootstrap();
        $configBootstrap->bootstrap($applicationConfig, $bootstrapRegistry);

        $this->assertArrayHasKey(Config::class, $bootstrapRegistry->getServices());
        $this->assertInstanceOf(Config::class, $bootstrapRegistry->getServices()[Config::class]);
        /** @var Config $config */
        $config = $bootstrapRegistry->getService(Config::class);
        $this->assertSame([
            'somekey' => [
                'key1' => 'key1value',
            ],
            'db' => [
                'user' => "myuser",
                'host' => "myhost",
                'pass' => "mynewpass",
            ],
        ], $config->all());
    }
}
