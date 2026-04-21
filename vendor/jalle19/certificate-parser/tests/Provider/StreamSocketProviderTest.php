<?php

namespace Jalle19\CertificateParser\Tests\Provider;

use Jalle19\CertificateParser\Provider\Exception\CertificateNotFoundException;
use Jalle19\CertificateParser\Provider\Exception\ConnectionTimeoutException;
use Jalle19\CertificateParser\Provider\Exception\DomainMismatchException;
use Jalle19\CertificateParser\Provider\Exception\NameResolutionException;
use Jalle19\CertificateParser\Provider\StreamContext;
use Jalle19\CertificateParser\Provider\StreamSocketProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class StreamSocketProviderTest
 * @package Jalle19\CertificateParser\Tests\Provider
 */
class StreamSocketProviderTest extends TestCase
{

    /**
     * @param string $url
     *
     * @dataProvider properCertificateProvider
     */
    public function testProperCertificateHandling($url)
    {
        $provider = new StreamSocketProvider($url);

        $this->assertInstanceOf(\OpenSSLCertificate::class, $provider->getRawCertificate());
    }


    public function testNonExistingDomain()
    {
        $this->expectException(NameResolutionException::class);

        $provider = new StreamSocketProvider('example.does.not.exist');
        $provider->getRawCertificate();
    }


    public function testNoCertificateFound()
    {
        $this->expectException(CertificateNotFoundException::class);

        $provider = new StreamSocketProvider('connectivitycheck.gstatic.com', 80);
        $provider->getRawCertificate();
    }


    public function testDomainMismatch()
    {
        $this->expectException(DomainMismatchException::class);

        $provider = new StreamSocketProvider('wrong.host.badssl.com');
        $provider->getRawCertificate();
    }


    /**
     *
     */
    public function testVerifyPeerName()
    {
        $provider = new StreamSocketProvider('wrong.host.badssl.com', StreamSocketProvider::DEFAULT_PORT,
            StreamSocketProvider::DEFAULT_TIMEOUT_SECONDS, new StreamContext(false));

        $this->assertInstanceOf(\OpenSSLCertificate::class, $provider->getRawCertificate());
    }


    public function testConnectionTimeoutException()
    {
        $this->expectException(ConnectionTimeoutException::class);

        // Force a timeout to occur
        $provider = new StreamSocketProvider('example.com', 443, 0);
        $provider->getRawCertificate();
    }


    /**
     * Tests that the stream context is stored and handled properly
     */
    public function testStreamContext()
    {
        $provider = new StreamSocketProvider('example.com');
        $this->assertNotNull($provider->getStreamContext());

        $streamContext = new StreamContext(false, 'example.com');
        $provider->setStreamContext($streamContext);
        $this->assertEquals($streamContext, $provider->getStreamContext());
    }


    /**
     * @return array
     */
    public static function properCertificateProvider(): array
    {
        return [
            // Completely valid
            ['www.google.com'],
            // Expired
            ['expired.badssl.com'],
            // Self-signed
            ['self-signed.badssl.com'],
            // Untrusted root
            ['untrusted-root.badssl.com'],
            // Revoked
            ['revoked.badssl.com'],
            // Incomplete chain
            ['incomplete-chain.badssl.com'],
        ];
    }

}
