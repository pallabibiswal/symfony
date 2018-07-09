<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Merchant
 *
 * @ORM\Table(name="merchant")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\MerchantRepository")
 */
class Merchant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="merchant_name", type="string", length=255)
     */
    private $merchantName;

    /**
     * @var string
     *
     * @ORM\Column(name="merchant_id", type="string", length=15)
     */
    private $merchantId;

    /**
     * @var device
     *
     * @ORM\OneToMany(targetEntity="Device", mappedBy="merchant")
     */
    private $device;

    /**
     * Merchant constructor.
     */
    public function __construct()
    {
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set merchantName
     *
     * @param string $merchantName
     *
     * @return Merchant
     */
    public function setMerchantName($merchantName)
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    /**
     * Get merchantName
     *
     * @return string
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }

    /**
     * Set merchantId
     *
     * @param string $merchantId
     *
     * @return Merchant
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Get merchantId
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }
}

