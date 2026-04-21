<?php

namespace Jalle19\CertificateParser\Tests\Provider;

use Jalle19\CertificateParser\Provider\StreamContext;
use PHPUnit\Framework\TestCase;

/**
 * Class StreamContextTest
 * @package Jalle19\CertificateParser\Tests\Provider
 */
class StreamContextTest extends TestCase
{

    /**
     * @param bool   $verifyPeerName
     * @param string $sniServerName
     * @param array  $expectedContext
     *
     * @dataProvider getArrayProvider
     */
    public function testGetArray($verifyPeerName, $sniServerName, $expectedContext)
    {
        $streamContext = new StreamContext($verifyPeerName, $sniServerName);

        $this->assertEquals($expectedContext, $streamContext->getArray());
    }


    /**
     * Tests that the getters and setters work properly
     */
    public function testGettersSetters()
    {
        $streamContext = new StreamContext();
        $streamContext->setVerifyPeerName(true);
        $this->assertTrue($streamContext->verifyPeerName());

        $streamContext->setSniServerName('example.com');
        $this->assertEquals($streamContext->getSniServerName(), 'example.com');
    }


    /**
     * @return array
     */
    public static function getArrayProvider()
    {
        return [
            [
                false,
                null,
                [
                    'ssl' => [
                        'capture_peer_cert' => true,
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                    ],
                ],
            ],
            [
                true,
                null,
                [
                    'ssl' => [
                        'capture_peer_cert' => true,
                        'verify_peer'       => false,
                        'verify_peer_name'  => true,
                    ],
                ],
            ],
            [
                true,
                null,
                [
                    'ssl' => [
                        'capture_peer_cert' => true,
                        'verify_peer'       => false,
                        'verify_peer_name'  => true,
                    ],
                ],
            ],
            [
                true,
                'example.com',
                [
                    'ssl' => [
                        'capture_peer_cert' => true,
                        'verify_peer'       => false,
                        'verify_peer_name'  => true,
                        'SNI_enabled'       => true,
                        'SNI_server_name'   => 'example.com',
                    ],
                ],
            ],
        ];
    }

}
