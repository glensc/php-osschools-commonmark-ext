<?php

namespace OSSchools\Extensions\CommonMark\Inline\Renderers;

use Embera\Embera;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;

class AutoEmbedRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    protected $config;

    /**
     * @param AbstractInline $inline
     * @param ElementRendererInterface $htmlRenderer
     * @return \League\CommonMark\HtmlElement|string|void
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Link)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }
        $embed = new Embera();
        foreach ($embed->getUrlInfo($inline->getUrl()) as $test) {
            echo $test;
        }

    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}