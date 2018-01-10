<?php

namespace OSSchools\Extensions\CommonMark\Inline\Parsers;

use League\CommonMark\Inline\Element\Text;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;
use OSSchools\Extensions\CommonMark\Element\StrikeThrough;

class StrikeThroughParser extends AbstractInlineParser
{
    public function getCharacters()
    {
        return ['~'];
    }

    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        $character = $cursor->getCharacter();
        if ($cursor->peek(1) != $character) {
            return false;
        }

        $tildes = $cursor->match('/^~~+/');
        if ($tildes === '') {
            false;
        }
        $previous_state = $cursor->saveState();
        $currentPosition = $cursor->getPosition();
        while ($matching_tildes = $cursor->match('/~~+/m')) {
            if ($matching_tildes === $tildes) {
                $text = mb_substr($cursor->getLine(), $currentPosition, $cursor->getPosition() - $currentPosition - strlen($tildes), 'utf-8');
                $text = preg_replace('/[ \n]+/', ' ', $text);
                $inlineContext->getContainer()->appendChild(new StrikeThrough(trim($text)));
                return true;
            }
        }
        $cursor->restoreState($previous_state);
        $inlineContext->getContainer()->appendChild(new Text($tildes));
        return false;
    }
}