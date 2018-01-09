<?php

namespace OSSchools\Extensions\CommonMark\InlineParsers;

use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Util\UrlEncoder;
use OSSchools\Extensions\CommonMark\Special\URLMeta;

class AutoLinkParser extends AbstractInlineParser
{
    // This link regex will only parse links starting in http or https
    const LINK_REGEX = '#^(https?)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?#i';

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        // The character must be filled in, so an "h" here works because we require http or https to prepend the link
        return ['h'];
    }

    /**
     * @param InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        if ($m = $cursor->match(self::LINK_REGEX)) {
            $urlMeta = new URLMeta($m);
            $inlineContext->getContainer()->appendChild(new Link(UrlEncoder::unescapeAndEncode($m), $urlMeta->parse()->title != null ? $urlMeta->parse()->title : $m));
            return true;
        }
        return false;
    }
}