<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Davey Shafik <me@daveyshafik.com>
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmarkjs)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Markua\Block\Element;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

class Aside extends AbstractBlock
{
    /**
     * {@inheritdoc}
     */
    public function canContain(AbstractBlock $block)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function acceptsLines()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isCode()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function matchesNextLine(Cursor $cursor)
    {
        if ($cursor->getIndent() <= 3 && $cursor->getNextNonSpaceCharacter() == 'A') {
            $cursor->advanceToNextNonSpaceOrNewline();
            if ($cursor->peek() === '>') {
                $cursor->advanceBy(2);
                if ($cursor->getCharacter() === ' ') {
                    $cursor->advance();
                }
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRemainingContents(ContextInterface $context, Cursor $cursor)
    {
        if ($cursor->isBlank()) {
            return;
        }

        $context->addBlock(new Paragraph());
        $cursor->advanceToNextNonSpaceOrNewline();
        $context->getTip()->addLine($cursor->getRemainder());
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLineBlank($blank)
    {
        $this->lastLineBlank = false;
    }
}
