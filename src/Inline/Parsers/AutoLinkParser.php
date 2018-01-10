<?php

namespace OSSchools\Extensions\CommonMark\Inline\Parsers;

use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Util\UrlEncoder;
use OSSchools\Extensions\CommonMark\Special\URLMeta;

class AutoLinkParser extends AbstractInlineParser
{
    // This link regex will only parse links starting in http or https
    const EMAIL_REGEX = '/^([a-zA-Z0-9.!#$%&\'*+\\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*)/i';
    const OTHER_LINK_REGEX = '/^[A-Za-z][A-Za-z0-9.+-]{1,31}:[^<>\x00-\x20]*/i';

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        // Get any alphanumeric character
        return array_merge(array_merge(range('a', 'z'), range('A', 'Z')), range(0, 9));
    }

    /**
     * @param InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        if ($m = $cursor->match(self::OTHER_LINK_REGEX)) {
            $urlMeta = new URLMeta($m);
            $inlineContext->getContainer()->appendChild(new Link(UrlEncoder::unescapeAndEncode($m), $urlMeta->parse()->title != null ? $urlMeta->parse()->title : $m));
            return true;
        } elseif ($m = $cursor->match(self::EMAIL_REGEX)) {
            $inlineContext->getContainer()->appendChild(new Link('mailto:' . UrlEncoder::unescapeAndEncode($m), $m));
            return true;
        }
        return false;
    }
}