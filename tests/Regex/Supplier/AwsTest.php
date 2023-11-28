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

use CaptainHook\Secrets\Detector;
use CaptainHook\Secrets\Regex\Supplier\Aws;
use PHPUnit\Framework\TestCase;

class AwsTest extends TestCase
{
    public function testDetectAws(): void
    {
        $haystack = 'bar AKIAIOSFODNN7EXAMPLE baz';
        $detector = Detector::create()->useSuppliers(new Aws());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }
}
