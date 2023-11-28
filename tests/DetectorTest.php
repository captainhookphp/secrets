<?php

/**
 * This file is part of CaptainHook Secrets.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CaptainHook\Secrets;

use CaptainHook\Secrets\Regex\Supplier\Aws;
use PHPUnit\Framework\TestCase;

class DetectorTest extends TestCase
{
    public function testDetectByRegex(): void
    {
        $haystack = 'foo bar baz';
        $detector = Detector::create()->useRegex('#b[a-z]r#');
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDetectBySupplierConfig(): void
    {
        $haystack = 'bar AKIAIOSFODNN7EXAMPLE baz';
        $detector = Detector::create()->useSupplierConfig(['\CaptainHook\Secrets\Regex\Supplier\Aws']);
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testFailDetectBySupplierConfigClassNotFound(): void
    {
        $this->expectException(\Exception::class);

        $detector = Detector::create()->useSupplierConfig(['\CaptainHook\Secrets\Regex\Supplier\FooBar']);
    }

    public function testFailDetectBySupplierConfigNotASupplier(): void
    {
        $this->expectException(\Exception::class);

        $detector = Detector::create()->useSupplierConfig(['\stdClass']);
    }

    public function testDetectBySupplier(): void
    {
        $haystack = 'bar AKIAIOSFODNN7EXAMPLE baz';
        $detector = Detector::create()->useSuppliers(new Aws());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }
}
