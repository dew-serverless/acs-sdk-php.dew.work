<?php

use App\Markdown\AcsLink\AcsLinkExtension;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Environment\EnvironmentInterface;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Renderer\HtmlRenderer;

test('acs link extension', function () {
    $environment = environmentForTestingAcsLinkExtension();

    $parser = new MarkdownParser($environment);
    $renderer = new HtmlRenderer($environment);

    $markdown = '[Reference](~~12345~~)';
    $expectedHtml = '<p><a target="_blank" rel="external nofollow noopener noreferrer" href="https://help.aliyun.com/document_detail/12345.html">Reference</a></p>';

    expect(rtrim($renderer->renderDocument($parser->parse($markdown))->getContent()))
        ->toBe($expectedHtml);
});

test('acs link extension with unmatched url format', function () {
    $environment = environmentForTestingAcsLinkExtension();

    $parser = new MarkdownParser($environment);
    $renderer = new HtmlRenderer($environment);

    $markdown = '[Reference](~~abc~~)';
    $expectedHtml = '<p><a href="~~abc~~">Reference</a></p>';

    expect(rtrim($renderer->renderDocument($parser->parse($markdown))->getContent()))
        ->toBe($expectedHtml);
});

function environmentForTestingAcsLinkExtension(): EnvironmentInterface
{
    return (new Environment)
        ->addExtension(new CommonMarkCoreExtension)
        ->addExtension(new AcsLinkExtension);
}
