<?php

/**
 * This file is part of CaptainHook Secrets.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace CaptainHook\Secrets\Entropy;

use CaptainHook\Secrets\Detector;
use CaptainHook\Secrets\Regex\Supplier\Aws;
use PHPUnit\Framework\TestCase;

class ShannonTest extends TestCase
{
    public function testEntropyWikiExample(): void
    {
        $this->assertEquals(1.85, round(Shannon::entropy('1223334444'), 2));
    }

    public function testEntropyEmptyString(): void
    {
        $this->assertEquals(0, Shannon::entropy(''));
    }

    public function testEntropyOneCharacterString(): void
    {
        $this->assertEquals(0, Shannon::entropy('A'));
    }

    public function testEntropyMultipleSimilarCharacters(): void
    {
        $this->assertEquals(0, Shannon::entropy('111111'));
    }

    public function testEntropyTwoCharacters(): void
    {
        $this->assertEquals(1.0, Shannon::entropy('111222'));
    }

    public function testEntropyRegularToken(): void
    {
        $this->assertTrue(Shannon::entropy('lg45ve1mz1yf21pb30qd') > 4);
    }

    public function testEntropyLongClassName(): void
    {
        $this->assertTrue(Shannon::entropy('EntropyDetectionManagerProvider') < 4);
    }
}
