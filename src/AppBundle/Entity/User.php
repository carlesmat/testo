<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    private $id;

    /**
     * Número d'equips que té l'usuari
     *
     * @ORM\Column(type="integer", name="numero_equips", options={"unsigned":true, "default":0})
     */
    private $nEquips;

    /**
     * Número de certificats que té l'usuari
     *
     * @ORM\Column(type="integer", name="numero_certificats", options={"unsigned":true, "default":0})
     */
    private $nCertificats;

    /**
     * Tipus d'usuari (final/SAP)
     *
     * @ORM\Column(type="string", length=15, name="tipus_client", nullable=false, options={"default":"final", "fixed":false, "comment":"Tipus d'usuari (final/SAP)"})
     */
    private $sTipusClient = 'final';

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nEquips
     *
     * @param integer $nEquips
     * @return User
     */
    public function setNEquips($nEquips)
    {
        $this->nEquips = $nEquips;

        return $this;
    }

    /**
     * Get nEquips
     *
     * @return integer
     */
    public function getNEquips()
    {
        return $this->nEquips;
    }

    /**
     * Set nCertificats
     *
     * @param integer $nCertificats
     * @return User
     */
    public function setNCertificats($nCertificats)
    {
        $this->nCertificats = $nCertificats;

        return $this;
    }

    /**
     * Get nCertificats
     *
     * @return integer
     */
    public function getNCertificats()
    {
        return $this->nCertificats;
    }

    /**
     * Set sTipusClient
     *
     * @param string $sTipusClient
     * @return User
     */
    public function setSTipusClient($sTipusClient)
    {
        $this->sTipusClient = $sTipusClient;

        return $this;
    }

    /**
     * Get sTipusClient
     *
     * @return string
     */
    public function getSTipusClient()
    {
        return $this->sTipusClient;
    }
}
