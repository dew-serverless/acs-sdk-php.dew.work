<?php

declare(strict_types=1);

namespace App\Markdown;

use App\Markdown\AcsLink\AcsLinkExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class ReferenceMarkdownConverter extends MarkdownConverter
{
    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(array $config = [])
    {
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);
        $environment->addExtension(new AcsLinkExtension);

        parent::__construct($environment);
    }
}
