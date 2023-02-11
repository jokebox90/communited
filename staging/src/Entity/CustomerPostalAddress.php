<?php

namespace App\Entity;

use App\Repository\CustomerPostalAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CustomerPostalAddressRepository::class)]
#[ORM\Index(name: "customer_postal_address_idx", columns: ["status", "customer_id"])]
class CustomerPostalAddress
{
    const STATUS_ACTIVE    = "active";
    const STATUS_INACTIVE  = "inactive";
    const AVAILABLE_STATUS = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 36)]
    private ?string $customerId = null;

    #[ORM\Column(length: 120)]
    private ?string $street = null;

    #[ORM\Column(length: 10)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 60)]
    private ?string $locality = null;

    #[ORM\Column(length: 60)]
    private ?string $country = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $residence = null;

    #[ORM\Column(nullable: true)]
    private ?int $floor = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $entryCode = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $intercom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: "postalAdress")]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'unique_id')]
    private Customer|null $customer = null;

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getlocality(): ?string
    {
        return $this->locality;
    }

    public function setlocality(string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function setResidence(?string $residence): self
    {
        $this->residence = $residence;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getEntryCode(): ?string
    {
        return $this->entryCode;
    }

    public function setEntryCode(?string $entryCode): self
    {
        $this->entryCode = $entryCode;

        return $this;
    }

    public function getIntercom(): ?string
    {
        return $this->intercom;
    }

    public function setIntercom(?string $intercom): self
    {
        $this->intercom = $intercom;

        return $this;
    }

    public function getAdditionalNotes(): ?string
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes(?string $additionalNotes): self
    {
        $this->additionalNotes = $additionalNotes;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function exchangeArray(array $array): self
    {
        if (in_array("uniqueId", array_keys($array))) {
            $this->setUniqueId($array["uniqueId"]);
        } else {
            $uuid = Uuid::uuid4();
            $this->setUniqueId($uuid->toString());
        }

        $this->setCustomerId($array["customerId"]);
        $this->setStreet($array["street"]);
        $this->setPostalCode($array["postalCode"]);
        $this->setlocality($array["locality"]);
        $this->setCountry($array["country"]);
        $this->setResidence($array["residence"]);
        $this->setFloor($array["floor"]);
        $this->setEntryCode($array["entryCode"]);
        $this->setIntercom($array["intercom"]);
        $this->setAdditionalNotes($array["additionalNotes"]);
        $this->setStatus($array["status"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"]        = $this->getUniqueId();
        $array["customerId"]      = $this->getCustomerId();
        $array["street"]          = $this->getStreet();
        $array["postalCode"]      = $this->getPostalCode();
        $array["locality"]        = $this->getlocality();
        $array["country"]         = $this->getCountry();
        $array["residence"]       = $this->getResidence();
        $array["floor"]           = $this->getFloor();
        $array["entryCode"]       = $this->getEntryCode();
        $array["intercom"]        = $this->getIntercom();
        $array["additionalNotes"] = $this->getAdditionalNotes();
        $array["status"]          = $this->getStatus();

        return $array;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
