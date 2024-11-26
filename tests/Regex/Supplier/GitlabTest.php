<?php

namespace CaptainHook\Secrets\Regex\Supplier;

use CaptainHook\Secrets\Detector;
use PHPUnit\Framework\TestCase;

final class GitlabTest extends TestCase
{
    public function testDetectSecret(): void
    {
        $haystack = 'bar glpat-mBvGsDcJUvxvFZktWpzz baz';
        $detector = Detector::create()->useSuppliers(new Gitlab());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDontDetectSecret(): void
    {
        $haystack = 'bar glpat-mBvGsDcJUvx... gitlab glpat-15487234 glpat-mBvG{}_JUvxvFZktWpzz';
        $detector = Detector::create()->useSuppliers(new Gitlab());
        $result   = $detector->detectIn($haystack);

        $this->assertFalse($result->wasSecretDetected());
        $this->assertCount(0, $result->matches());
    }
}
