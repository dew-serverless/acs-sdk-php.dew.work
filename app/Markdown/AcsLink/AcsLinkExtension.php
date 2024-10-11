<?php

declare(strict_types=1);

namespace App\Markdown\AcsLink;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\ExtensionInterface;

final class AcsLinkExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addEventListener(
            DocumentParsedEvent::class,
            new AcsLinkProcessor($environment->getConfiguration()),
            priority: -50
        );
    }
}
