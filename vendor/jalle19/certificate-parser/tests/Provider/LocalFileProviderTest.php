<?php

namespace Jalle19\CertificateParser\Tests\Provider;

use Jalle19\CertificateParser\Parser;
use Jalle19\CertificateParser\Provider\Exception\FileNotFoundException;
use Jalle19\CertificateParser\Provider\LocalFileProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class LocalFileProviderTest
 * @package Jalle19\CertificateParser\Tests\Provider
 */
class LocalFileProviderTest extends TestCase
{

    public function testFileNotFound()
    {
        $this->expectException(FileNotFoundException::class);

        new LocalFileProvider('/tmp/does-not-exist');
    }


    /**
     * Tests that getRawCertificate() works correctly
     */
    public function testGetRawCertificate()
    {
        $parser            = new Parser();
        $parserResults     = $parser->parse(new LocalFileProvider(__DIR__ . '/../../resources/ssl-cert-snakeoil.pem'));
        $rawCertificate    = $parserResults->getRawCertificate();
        $parsedCertificate = $parserResults->getParsedCertificate();

        $this->assertCount(1, $rawCertificate['extensions']);
        $this->assertEquals('localhost', $parsedCertificate->getIssuer());
        $this->assertEquals('localhost', $parsedCertificate->getSubject());
    }

}
