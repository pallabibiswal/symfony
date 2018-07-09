<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Device
 *
 * @ORM\Table(name="device")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\DeviceRepository")
 */
class Device
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
     * @ORM\Column(name="device_type", type="string", length=30)
     */
    private $deviceType;

    /**
     * @var string
     *
     * @ORM\Column(name="device_id", type="string", length=20)
     */
    private $deviceId;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Merchant", inversedBy="device")
     * @ORM\JoinColumn(name="merchant_id", referencedColumnName="id")
     */
    private $merchant;


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
     * Set deviceType
     *
     * @param string $deviceType
     *
     * @return Device
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * Get deviceType
     *
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Get Device ID
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set Device ID
     * @param string $deviceId
     *
     * @return Device
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get Merchant
     *
     * @return string
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * Set Merchant
     *
     * @param object $merchant
     * @return merchant
     */
    public function setMerchant($merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }
}

