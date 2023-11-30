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

class PasswordTest extends TestCase
{
    public function testDetectSecret(): void
    {
        $haystack = 'password = "af4f573i21a7ce0h8715412a"';
        $detector = Detector::create()->useSuppliers(new Password());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDontDetectSecret(): void
    {
        $haystack = '"password", "someStuff", "RootPassword", "root"';
        $detector = Detector::create()->useSuppliers(new Stripe());
        $result   = $detector->detectIn($haystack);

        $this->assertFalse($result->wasSecretDetected());
        $this->assertCount(0, $result->matches());
    }
}
