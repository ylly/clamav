<?php

namespace YllyClamavTest\Response;

use PHPUnit\Framework\TestCase;
use YllyClamavScan\Response\ScanResponse;

final class ScanResponseTest extends TestCase
{
    /**
     * @dataProvider statusProvider
     */
    public function testSimpleStatus($excepted, $scanResult)
    {
        $response = new ScanResponse($scanResult);

        $this->assertSame($excepted, $response->getStatus());
    }

    public function statusProvider()
    {
        return [
            [ScanResponse::CLAMAV_CLEAN, 'OK'],
            [ScanResponse::CLAMAV_CLEAN, 'test OK'],
            [ScanResponse::CLAMAV_INFECT, '/root/text.txt FOUND'],
            [ScanResponse::CLAMAV_INFECT, <<<'EOF'
/root/text.txt FOUND
/root/text2.txt FOUND
/tmp/text.txt FOUND
EOF
            ],
            [ScanResponse::CLAMAV_UNCHECK, <<<'EOF'
/root/text.txt ERROR
/root/text2.txt ERROR
/tmp/text.txt ERROR
EOF
            ],
        ];
    }

    public function testMixedStatus()
    {
        $response = new ScanResponse(<<<'EOF'
/root/text.txt FOUND
/root/text2.txt ERROR
/tmp/text.txt FOUND
EOF
        );

        $this->assertEquals(ScanResponse::CLAMAV_INFECT|ScanResponse::CLAMAV_UNCHECK, $response->getStatus());
    }
}
