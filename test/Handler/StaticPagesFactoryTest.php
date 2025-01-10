<?php

declare(strict_types=1);

namespace MezzioTest\StaticPages\Handler;

use Mezzio\Exception\MissingDependencyException;
use Mezzio\StaticPages\Handler\StaticPagesHandler;
use Mezzio\StaticPages\Handler\StaticPagesHandlerFactory;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class StaticPagesFactoryTest extends TestCase
{
    /** @var MockObject&ContainerInterface  */
    protected $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testFactoryWhenContainerHasATemplateRendererInterface(): void
    {
        $templateInterface = $this->createMock(TemplateRendererInterface::class);

        $this->container
            ->expects($this->once())
            ->method('has')
            ->with(TemplateRendererInterface::class)
            ->willReturn(true);
        $this->container
            ->method('get')
            ->with(TemplateRendererInterface::class)
            ->willReturn($templateInterface);

        $factory = new StaticPagesHandlerFactory();

        $page = $factory($this->container);

        $this->assertInstanceOf(StaticPagesHandler::class, $page);
    }

    public function testFactoryWhenContainerDoesNotHaveATemplateRendererInterface(): void
    {
        $this->expectException(MissingDependencyException::class);
        $this->expectExceptionMessage("TemplateRendererInterface object not found in the container");

        $this->container
            ->expects($this->once())
            ->method('has')
            ->with(TemplateRendererInterface::class)
            ->willReturn(false);

        $factory = new StaticPagesHandlerFactory();

        $page = $factory($this->container);

        $this->assertInstanceOf(StaticPagesHandler::class, $page);
    }
}
