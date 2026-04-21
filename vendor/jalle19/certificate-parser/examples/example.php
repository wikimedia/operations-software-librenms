<?php

use AcmePhp\Ssl\Exception\CertificateParsingException;
use Jalle19\CertificateParser\Provider\Exception\FileNotFoundException;
use Jalle19\CertificateParser\Provider\Exception\ProviderException;
use Jalle19\CertificateParser\Provider\Exception\ConnectionTimeoutException;
use Jalle19\CertificateParser\Provider\Exception\DomainMismatchException;
use Jalle19\CertificateParser\Provider\Exception\NameResolutionException;
use Jalle19\CertificateParser\Provider\Exception\CertificateNotFoundException;
use Jalle19\CertificateParser\Parser;
use Jalle19\CertificateParser\Provider\LocalFileProvider;
use Jalle19\CertificateParser\Provider\StreamContext;
use Jalle19\CertificateParser\Provider\StreamSocketProvider;

require_once(__DIR__ . '/../vendor/autoload.php');

// Create a provider. The provider is used to retrieve the raw certificate details from a URL.
// If you don't want DomainMismatchException to be thrown if the peer name doesn't match, pass
// false as the last parameter to the constructor.
$provider = new StreamSocketProvider('www.google.com');

// You can manipulate the stream context used when fetching the certificate by passing a StreamContext
// object to the constructor or using the setter
$provider->setStreamContext(new StreamContext());

// Create the parser instance
$parser = new Parser();

// Parse the certificate and print some details about it. Handle all exception types separately
// to illustrate what can be thrown
try {
    $parserResults = $parser->parse($provider);

    // Now we can inspect the certificate
    $certificate = $parserResults->getParsedCertificate();

    echo 'Issuer:                  ' . $certificate->getIssuer() . PHP_EOL;
    echo 'Subject:                 ' . $certificate->getSubject() . PHP_EOL;
    echo 'Subject alternate names: ' . implode(', ', $certificate->getSubjectAlternativeNames()) . PHP_EOL;
    echo 'Valid until:             ' . $certificate->getValidTo()->format('r') . PHP_EOL;

    // We can also inspect the raw certificate directly
    $rawCertificate = $parserResults->getRawCertificate();

    // We can also get the certificate fingerprint
    $fingerprint = $parserResults->getFingerprint();

    // We can also get the certificate in PEM format (as a string)
    $pemString = $parserResults->getPemString();

    // Let's parse a certificate from a local file instead
    $parserResults = $parser->parse(new LocalFileProvider(__DIR__ . '/../resources/ssl-cert-snakeoil.pem'));
    $certificate   = $parserResults->getParsedCertificate();

    echo PHP_EOL . 'Local file issuer: ' . $certificate->getIssuer() . PHP_EOL;
} catch (NameResolutionException $e) {

} catch (CertificateNotFoundException $e) {

} catch (DomainMismatchException $e) {

} catch (ConnectionTimeoutException $e) {

} catch (FileNotFoundException $e) {
    // Thrown by LocalFileProvider if the specified PEM file doesn't exist
} catch (ProviderException $e) {
    // All of the above exceptions inherit from this one, so if you don't what happened you
    // can just catch this
    var_dump($e->getMessage());
} catch (CertificateParsingException $e) {
    // The certificate was successfully retrieved but couldn't be parsed
    var_dump($e->getMessage());
}
