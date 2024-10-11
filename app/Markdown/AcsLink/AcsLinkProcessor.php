<?php

declare(strict_types=1);

namespace App\Markdown\AcsLink;

use Illuminate\Support\Str;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\Config\ConfigurationInterface;

final class AcsLinkProcessor
{
    public function __construct(
        private ConfigurationInterface $config
    ) {
        //
    }

    public function __invoke(DocumentParsedEvent $e): void
    {
        foreach ($e->getDocument()->iterator() as $link) {
            if (! $link instanceof Link) {
                continue;
            }

            // The URL to the Alibaba Cloud in the markdown is conventionally
            // something like ~~12345~~.
            $id = Str::of($link->getUrl())->match('/~~(\d+)~~/');

            if ($id->isEmpty()) {
                continue;
            }

            // Update the URL
            $link->setUrl("https://help.aliyun.com/document_detail/$id.html");

            // Open in new tab or window
            $link->data->set('attributes/target', '_blank');

            // Define the relationship with the link
            $link->data->append('attributes/rel', 'external');
            $link->data->append('attributes/rel', 'nofollow');
            $link->data->append('attributes/rel', 'noopener');
            $link->data->append('attributes/rel', 'noreferrer');
        }
    }
}
