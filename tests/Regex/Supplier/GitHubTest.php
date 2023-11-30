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

class GitHubTest extends TestCase
{
    public function testDetectSecret(): void
    {
        $haystack = 'bar ghp_af4f573i21a7ce0h8715412ae94qwe464345 baz';
        $detector = Detector::create()->useSuppliers(new GitHub());
        $result   = $detector->detectIn($haystack);

        $this->assertTrue($result->wasSecretDetected());
        $this->assertCount(1, $result->matches());
    }

    public function testDontDetectSecret(): void
    {
        $haystack = 'bar ghp af4f573i21a github e94qwe464345 baz';
        $detector = Detector::create()->useSuppliers(new GitHub());
        $result   = $detector->detectIn($haystack);

        $this->assertFalse($result->wasSecretDetected());
        $this->assertCount(0, $result->matches());
    }
}
