<?php

declare(strict_types=1);

namespace Mezzio\StaticPages\Handler;

use Mezzio\Exception\MissingDependencyException;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StaticPagesHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $template = $this->getTemplateRenderer($container);

        return new StaticPagesHandler($template);
    }

    /**
     * @throws MissingDependencyException
     */
    public function getTemplateRenderer(ContainerInterface $container): TemplateRendererInterface
    {
        if ($container->has(TemplateRendererInterface::class)) {
            /** @var TemplateRendererInterface $templateRenderer */
            $templateRenderer = $container->get(TemplateRendererInterface::class);
            return $templateRenderer;
        }

        throw new MissingDependencyException(
            "TemplateRendererInterface object not found in the container"
        );
    }
}
