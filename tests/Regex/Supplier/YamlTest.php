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

namespace CaptainHook\Secrets\Regex\Supplier;

use CaptainHook\Secrets\Regexer;
use PHPUnit\Framework\TestCase;

class YamlTest extends TestCase
{
    public function testDetectSecretWithQuotes(): void
    {
        $haystack = 'secret: \'my-password\'';
        $regexer  = Regexer::create()->useGroupedSupplier(new Yaml());
        $result   = $regexer->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
        $this->assertEquals('my-password', $result->matches()[0]);
    }

    public function testDetectSecretWithoutQuotes(): void
    {
        $haystack = 'foo: my-password';
        $regexer  = Regexer::create()->useGroupedSupplier(new Yaml());
        $result   = $regexer->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
        $this->assertEquals('my-password', $result->matches()[0]);
    }

    public function testDontDetectSecret(): void
    {
        $haystack = 'var:';
        $regexer  = Regexer::create()->useGroupedSupplier(new Yaml());
        $result   = $regexer->detectIn($haystack);

        $this->assertFalse($result->wasSecretDetected());
    }
}
