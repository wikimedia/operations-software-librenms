# certificate-parser

[![CI](https://github.com/Jalle19/certificate-parser/actions/workflows/ci.yml/badge.svg)](https://github.com/Jalle19/certificate-parser/actions/workflows/ci.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jalle19/certificate-parser/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jalle19/certificate-parser/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/Jalle19/certificate-parser/badge.svg)](https://coveralls.io/github/Jalle19/certificate-parser)

A proper SSL/TLS certificate parser library for PHP

## Motivation

There are a couple of other existing certificate parsers for PHP out there, but they're all lacking in some way. Some 
lack configurability (e.g. not being able to change the port to something other than 443), others have mediocre error 
handling (or none), while some don't allow you to parse certificates that are considered invalid (e.g. an expired or 
self-signed certificate).

## Features

* Completely configurable. This library uses *providers* to fetch the underlying X.509 certificate before parsing them. 
This means you can parse e.g. local PEM files too, not just certificates from remote URLs.
* Fault-tolerant. Just because PHP's default settings trigger an error when parsing a certificate doesn't mean you 
don't want to parse it. This library can handle both self-signed certificates and certificates where the domain name 
doesn't match.
* Granular error handling. There are multiple exception types for various failure scenarios, so you can choose 
exactly how you want each type of error to be handled.

## Requirements

* PHP >= 8.2 with OpenSSL support

## Installation

```
composer require jalle19/certificate-parser
```

## Usage 

```php
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
```

You can also find this example in the `examples/` directory. If you run it using `php examples/example.php` it should 
print something like this:

```
Issuer:                  Google Internet Authority G2
Subject:                 www.google.com
Subject alternate names: www.google.com
Valid until:             Thu, 26 Jan 2017 01:13:00 +0000
```

### Writing a custom provider

This library ships with two providers:

* `StreamSocketProvider` - retrieves certificates from a remote server using `stream_socket_client`
* `LocalFileProvider` - retrieves certificates using local files

If these don't suit your needs, create a new provider by implementing the `ProviderInterface` interface.

## License

MIT

## Credits

* https://github.com/acmephp/ssl for the actual parser
* https://github.com/spatie/ssl-certificate and others for inspiration
