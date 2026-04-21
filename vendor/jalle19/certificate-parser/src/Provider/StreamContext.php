<?php

namespace Jalle19\CertificateParser\Provider;

/**
 * Class StreamContext
 * @package Jalle19\CertificateParser\Provider
 */
class StreamContext
{

    /**
     * @var bool
     */
    private $verifyPeerName;

    /**
     * @var string
     */
    private $sniServerName;


    /**
     * StreamContext constructor.
     *
     * @param bool        $verifyPeerName (optional)
     * @param string|null $sniServerName  (optional)
     */
    public function __construct($verifyPeerName = true, $sniServerName = null)
    {
        $this->verifyPeerName = $verifyPeerName;
        $this->sniServerName  = $sniServerName;
    }


    /**
     * @return boolean
     */
    public function verifyPeerName()
    {
        return $this->verifyPeerName;
    }


    /**
     * @param boolean $verifyPeerName
     */
    public function setVerifyPeerName($verifyPeerName)
    {
        $this->verifyPeerName = $verifyPeerName;
    }


    /**
     * @return string
     */
    public function getSniServerName()
    {
        return $this->sniServerName;
    }


    /**
     * @param string $sniServerName
     */
    public function setSniServerName($sniServerName)
    {
        $this->sniServerName = $sniServerName;
    }
    

    /**
     * @return array
     */
    public function getArray()
    {
        $context = [
            'ssl' => [
                'capture_peer_cert' => true,
                'verify_peer'       => false,
                'verify_peer_name'  => $this->verifyPeerName(),
            ],
        ];

        if ($this->sniServerName !== null) {
            $context['ssl']['SNI_enabled']     = true;
            $context['ssl']['SNI_server_name'] = $this->getSniServerName();
        }

        return $context;
    }


    /**
     * @return resource
     */
    public function getResource()
    {
        return stream_context_create($this->getArray());
    }
}
