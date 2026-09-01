<?php

namespace Jalle19\CertificateParser\Tests;

use AcmePhp\Ssl\ParsedCertificate;
use Jalle19\CertificateParser\Parser;
use Jalle19\CertificateParser\Provider\Exception\NameResolutionException;
use Jalle19\CertificateParser\Provider\StreamSocketProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class ParserTest
 * @package Jalle19\CertificateParser\Tests
 */
class ParserTest extends TestCase
{

    public function testFailedParse()
    {
        $this->expectException(NameResolutionException::class);

        $parser = new Parser();
        $parser->parse(new StreamSocketProvider('non.existing.domain'));
    }


    /**
     *
     */
    public function testGetParsedCertificate()
    {
        $parser        = new Parser();
        $parserResults = $parser->parse(new StreamSocketProvider('www.google.com'));

        $this->assertInstanceOf(ParsedCertificate::class, $parserResults->getParsedCertificate());
    }


    /**
     *
     */
    public function testGetRawCertificate()
    {
        $parser         = new Parser();
        $parserResults  = $parser->parse(new StreamSocketProvider('www.google.com'));
        $rawCertificate = $parserResults->getRawCertificate();

        $this->assertArrayHasKey('name', $rawCertificate);
        $this->assertArrayHasKey('subject', $rawCertificate);
    }

}
