<?php

namespace OSSchools\Extensions\CommonMark\Inline\Renderers;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use OSSchools\Extensions\CommonMark\Inline\Element\StrikeThrough;

class StrikeThroughRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof StrikeThrough)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $attrs = [];
        foreach ($inline->getData('attributes', []) as $key => $value) {
            $attrs[$key] = $value;
        }
        return new HtmlElement('del', $attrs, $inline->getContent());
    }
}