<?php

declare(strict_types=1);

namespace Mezzio\StaticPages;

final class ConfigProvider
{
    /**
     * @return array<string,array>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array<string,array<string,string>>
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                Handler\StaticPagesHandler::class => Handler\StaticPagesHandlerFactory::class,
            ],
        ];
    }
}
