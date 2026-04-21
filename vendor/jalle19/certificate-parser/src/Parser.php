<?php

namespace Jalle19\CertificateParser;

use AcmePhp\Ssl\Certificate;
use AcmePhp\Ssl\Exception\CertificateParsingException;
use AcmePhp\Ssl\Parser\CertificateParser;
use Jalle19\CertificateParser\Provider\Exception\ProviderException;
use Jalle19\CertificateParser\Provider\ProviderInterface;

/**
 * Class Parser
 * @package Jalle19\CertificateParser
 */
class Parser
{

    /**
     * Attempts to parse the certificate using the specified provider
     *
     * @param ProviderInterface $provider
     *
     * @throws CertificateParsingException
     * @throws ProviderException
     *
     * @return ParserResults
     */
    public function parse(ProviderInterface $provider)
    {
        $parser = new CertificateParser();

        // Store the raw (array format) certificate, the PEM string and the parsed certificate in the results
        $rawCertificate = $provider->getRawCertificate();
        openssl_x509_export($rawCertificate, $pemString);
        $parsedCertificate = $parser->parse(new Certificate($pemString));

        return new ParserResults($parsedCertificate,
            openssl_x509_parse($rawCertificate),
            $pemString,
            openssl_x509_fingerprint($pemString));
    }

}
