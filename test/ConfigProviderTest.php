<?php

declare(strict_types=1);

namespace MezzioTest\StaticPages;

use Mezzio\StaticPages\ConfigProvider;
use Mezzio\StaticPages\Handler\StaticPagesHandler;
use Mezzio\StaticPages\Handler\StaticPagesHandlerFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Mezzio\StaticPages\ConfigProvider
 */
class ConfigProviderTest extends TestCase
{
    public function testHasDependencies(): void
    {
        $this->assertArrayHasKey(
            'dependencies',
            (new ConfigProvider())()
        );
    }

    public function testCanGetDependencies(): void
    {
        $this->assertEquals(
            [
                'factories' => [
                    StaticPagesHandler::class => StaticPagesHandlerFactory::class,
                ],
            ],
            (new ConfigProvider())->getDependencies()
        );
    }
}
