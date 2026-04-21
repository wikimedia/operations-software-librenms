<?php

namespace Jalle19\CertificateParser\Tests;

use AcmePhp\Ssl\ParsedCertificate;
use Jalle19\CertificateParser\Parser;
use Jalle19\CertificateParser\ParserResults;
use Jalle19\CertificateParser\Provider\LocalFileProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserResultsTest
 * @package Jalle19\CertificateParser\Tests
 */
class ParserResultsTest extends TestCase
{

    const SNAKE_OIL_CERTIFICATE_PATH = __DIR__ . '/../resources/ssl-cert-snakeoil.pem';

    /**
     * @var ParserResults
     */
    private $parserResults;


    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $parser   = new Parser();
        $provider = new LocalFileProvider(self::SNAKE_OIL_CERTIFICATE_PATH);

        $this->parserResults = $parser->parse($provider);
    }


    /**
     * Tests that getParsedCertificate() works correctly
     */
    public function testGetParsedCertificate()
    {
        $this->assertInstanceOf(ParsedCertificate::class, $this->parserResults->getParsedCertificate());
    }


    /**
     * Tests that getRawCertificate() works correctly
     */
    public function testGetRawCertificate()
    {
        $this->assertCount(1, $this->parserResults->getRawCertificate()['extensions']);
    }


    /**
     * Tests that getFingerprint() works correctly
     */
    public function testGetFingerprint()
    {
        $this->assertEquals('026e630d487a3921380f9d1e77c7163a62aa3f67', $this->parserResults->getFingerprint());
    }


    /**
     * Tests that getPemString() works correctly
     */
    public function testGetPemString()
    {
        $this->assertStringContainsString('BEGIN CERTIFICATE', $this->parserResults->getPemString());
    }

}
