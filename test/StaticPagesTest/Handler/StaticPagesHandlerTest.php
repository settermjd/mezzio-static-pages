<?php

declare(strict_types=1);

namespace Settermjd\StaticPages\Test\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Exception\InvalidArgumentException;
use Mezzio\Router\RouteResult;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Settermjd\StaticPages\Handler\StaticPagesHandler;

class StaticPagesHandlerTest extends TestCase
{
    private MockObject&ContainerInterface $container;

    private MockObject&RouterInterface $router;

    private MockObject&TemplateRendererInterface $renderer;

    private MockObject&ServerRequestInterface $request;

    /** @var   */
    private MockObject&RouteResult $routeResult;

    protected function setUp(): void
    {
        $this->container   = $this->createMock(ContainerInterface::class);
        $this->router      = $this->createMock(RouterInterface::class);
        $this->renderer    = $this->createMock(TemplateRendererInterface::class);
        $this->request     = $this->createMock(ServerRequestInterface::class);
        $this->routeResult = $this->createMock(RouteResult::class);
    }

    public function testReturnsHtmlResponseWhenRequestedRouteIsNamedCorrectly(): void
    {
        $this->renderer
            ->expects($this->once())
            ->method('render')
            ->with('static-pages::terms')
            ->willReturn('');

        $page = new StaticPagesHandler($this->router, $this->renderer);

        $this->routeResult
            ->expects($this->once())
            ->method('getMatchedRouteName')
            ->willReturn('static.terms');

        $this->request
            ->expects($this->once())
            ->method('getAttribute')
            ->with(RouteResult::class)
            ->willReturn($this->routeResult);

        $response = $page->handle($this->request);

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }

    public function testThrowsExceptionWhenRequestedRouteHasNoName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Route has no name set");

        $this->renderer
            ->expects($this->never())
            ->method('render')
            ->with('static-pages::terms')
            ->willReturn('');

        $page = new StaticPagesHandler($this->router, $this->renderer);

        $this->routeResult
            ->expects($this->once())
            ->method('getMatchedRouteName')
            ->willReturn(false);

        $this->request
            ->expects($this->once())
            ->method('getAttribute')
            ->with(RouteResult::class)
            ->willReturn($this->routeResult);

        $page->handle($this->request);
    }

    #[DataProvider("invalidRouteNameDataProvider")]
    public function testThrowsExceptionWhenTheRequestedRouteNameDoesNotMatchTheExpectedFormat(string $routeName): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Route's name does not match the expected format.");

        $this->renderer
            ->expects($this->never())
            ->method('render')
            ->with('static-pages::terms')
            ->willReturn('');

        $page = new StaticPagesHandler($this->router, $this->renderer);

        $this->routeResult
            ->expects($this->once())
            ->method('getMatchedRouteName')
            ->willReturn($routeName);

        $this->request
            ->expects($this->once())
            ->method('getAttribute')
            ->with(RouteResult::class)
            ->willReturn($this->routeResult);

        $page->handle($this->request);
    }

    /**
     * @return array<array<int,string>>
     */
    public static function invalidRouteNameDataProvider(): array
    {
        return [
            [
                'terms',
            ],
            [
                'shonky.terms',
            ],
            [
                'static.',
            ],
            [
                '.terms',
            ],
            [
                'static_terms',
            ],
        ];
    }
}
