<?php

namespace OSSchools\Extensions\CommonMark\InlineRenderers;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class ExternalLinkRenderer implements InlineRendererInterface
{
    private $host;

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Link)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $attrs = array();

        $attrs['href'] = $inline->getUrl();

        if (isset($inline->attributes['title'])) {
            $attrs['title'] = $inline->data['title'];
        }

        if ($this->isExternalUrl($inline->getUrl())) {
            $attrs['class'] = 'text-danger';
        }

        return new HtmlElement('a', $attrs, $htmlRenderer->renderInlines($inline->children()));
    }

    private function isExternalUrl($url)
    {
        return parse_url($url, PHP_URL_HOST) !== $this->host;
    }
}