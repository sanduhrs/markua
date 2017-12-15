<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Davey Shafik <me@daveyshafik.com
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmarkjs)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Markua\Block\Parser;

use League\CommonMark\Block\Parser\AbstractBlockParser;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\Markua\Block\Element\Aside;

class AsideParser extends AbstractBlockParser
{
    /**
     * @param ContextInterface $context
     * @param Cursor $cursor
     *
     * @return bool
     */
    public function parse(ContextInterface $context, Cursor $cursor)
    {
        if ($cursor->getNextNonSpaceCharacter() !== 'A' ||
            $cursor->getCharacter($cursor->getNextNonSpacePosition() + 1) !== '>') {
            return false;
        }

        $cursor->advanceToNextNonSpaceOrNewline();
        if ($cursor->peek() === '>') {
            $cursor->advanceBy(2);
            if ($cursor->getCharacter() === ' ') {
                $cursor->advance();
            }
        }

        $context->addBlock(new Aside());

        return true;
    }
}
