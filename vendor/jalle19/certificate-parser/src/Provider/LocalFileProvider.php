<?php

namespace Jalle19\CertificateParser\Provider;

use Jalle19\CertificateParser\Provider\Exception\FileNotFoundException;

/**
 * Class LocalFileProvider
 * @package Jalle19\CertificateParser\Provider
 */
class LocalFileProvider implements ProviderInterface
{

    /**
     * @var string
     */
    private $filePath;


    /**
     * LocalFileProvider constructor.
     *
     * @param string $filePath
     *
     * @throws FileNotFoundException if the file doesn't exist
     */
    public function __construct($filePath)
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException($filePath . ' does not exist or is not readable');
        }

        $this->filePath = $filePath;
    }


    /**
     * @inheritdoc
     */
    public function getRawCertificate()
    {
        return openssl_x509_read(file_get_contents($this->filePath));
    }

}
