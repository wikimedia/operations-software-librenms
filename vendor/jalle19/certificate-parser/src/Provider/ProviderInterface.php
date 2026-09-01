<?php

namespace Jalle19\CertificateParser\Provider;

use Jalle19\CertificateParser\Provider\Exception\ProviderException;

/**
 * Interface ProviderInterface
 * @package Jalle19\CertificateParser\Provider
 */
interface ProviderInterface
{

    /**
     * @return resource the raw X.509 certificate
     *
     * @throws ProviderException
     */
    public function getRawCertificate();

}
