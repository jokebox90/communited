<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use App\Service\UniqueIdGenerator;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Faker\UniqueGenerator;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\Table("shop_contacts")]
class Contact
{
    const STATUS_ACTIVE    = "actif";
    const STATUS_INACTIVE  = "inactif";
    const STATUS_DELETED   = "supprimé";
    const AVAILABLE_STATUS = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_DELETED,
    ];

    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modifiedAt = null;

    #[ORM\Column(length: 60)]
    private ?string $contactName = null;

    #[ORM\Column(length: 60)]
    private ?string $emailAddress = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 120)]
    private ?string $street = null;

    #[ORM\Column(length: 10)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 60)]
    private ?string $locality = null;

    #[ORM\Column(length: 60)]
    private ?string $country = null;

    #[ORM\Column(length: 14)]
    private ?string $siret = null;

    #[ORM\Column(length: 12)]
    private ?string $vat = null;

    #[ORM\Column(length: 60)]
    private ?string $role = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $additionalNotes = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(name: 'merchant_id', referencedColumnName: 'unique_id')]
    private ?Merchant $merchant = null;

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getMerchant(): ?Merchant
    {
        return $this->merchant;
    }

    public function setMerchant(?Merchant $merchant): self
    {
        $this->merchant = $merchant;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(string $locality): self
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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getAdditionalNotes(): ?string
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes(string $additionalNotes): self
    {
        $this->additionalNotes = $additionalNotes;

        return $this;
    }

    public function exchangeArray(array $array):self
    {
        if (in_array("merchantId", array_keys($array))) {
            $this->setUniqueId($array["uniqueId"]);
        } else {
            $uuid = new UniqueIdGenerator();
            $this->setUniqueId($uuid->create());
        }

        $now = new DateTime();
        if (in_array("createdAt", array_keys($array))) {
            $this->setCreatedAt(DateTime::createFromFormat(DateTime::ATOM, $array["createdAt"]));
        } else {
            $this->setCreatedAt($now);
        }

        if (in_array("modifiedAt", array_keys($array))) {
            $this->setModifiedAt(DateTime::createFromFormat(DateTime::ATOM, $array["modifiedAt"]));
        } else {
            $this->setModifiedAt($now);
        }

        $this->setContactName($array["contactName"]);
        $this->setRole($array["role"]);
        $this->setEmailAddress($array["emailAddress"]);
        $this->setPhoneNumber($array["phoneNumber"]);
        $this->setStreet($array["street"]);
        $this->setPostalCode($array["postalCode"]);
        $this->setLocality($array["locality"]);
        $this->setCountry($array["country"]);
        $this->setSiret($array["siret"]);
        $this->setVat($array["vat"]);
        $this->setAdditionalNotes($array["additionalNotes"]);
        $this->setStatus($array["status"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"]        = $this->getUniqueId();
        $array["merchantId"]      = $this->getMerchant()->getUniqueId();
        $array["status"]          = $this->getStatus();
        $array["createdAt"]       = $this->getCreatedAt()->format(DateTime::ATOM);
        $array["modifiedAt"]      = $this->getModifiedAt()->format(DateTime::ATOM);
        $array["contactName"]     = $this->getContactName();
        $array["emailAddress"]    = $this->getEmailAddress();
        $array["phoneNumber"]     = $this->getPhoneNumber();
        $array["street"]          = $this->getStreet();
        $array["postalCode"]      = $this->getPostalCode();
        $array["locality"]        = $this->getLocality();
        $array["country"]         = $this->getCountry();
        $array["siret"]           = $this->getSiret();
        $array["vat"]             = $this->getVat();
        $array["additionalNotes"] = $this->getAdditionalNotes();

        return $array;
    }
}
