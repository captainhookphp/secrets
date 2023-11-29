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
use PHPUnit\Framework\TestCase;

class AwsTest extends TestCase
{
    public function testDetectSecretToken(): void
    {
        $haystack = 'bar AKIAIOSFODNN7EXAMPLE baz';
        $detector = Detector::create()->useSuppliers(new Aws());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDetectSecretKey(): void
    {
        $haystack = '{"AwsSecretAccessKey": "ga34h0sd+7f654azt65dax+as00sdh+jb99mn+as"}';
        $detector = Detector::create()->useSuppliers(new Aws());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDetectSecretAccountId(): void
    {
        $haystack = '{"AwsAccountID": "7456-5437-4352"}';
        $detector = Detector::create()->useSuppliers(new Aws());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDontDetectSecret(): void
    {
        $haystack = 'Aws Account secret 5437....';
        $detector = Detector::create()->useSuppliers(new Aws());
        $result   = $detector->detectIn($haystack);

        $this->assertFalse($result->wasSecretDetected());
    }
}
