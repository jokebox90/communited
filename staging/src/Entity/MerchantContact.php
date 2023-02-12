<?php

namespace App\Entity;

use App\Repository\MerchantContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: MerchantContactRepository::class)]
class MerchantContact
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $merchantId = null;

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

    #[ORM\Column(length: 30)]
    private ?string $activity = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $additionalNotes = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?Merchant $merchant = null;

    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    public function setMerchantId(string $merchantId): self
    {
        $this->merchantId = $merchantId;

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

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function exchangeArray(array $array):self
    {
        if (in_array("merchantId", array_keys($array))) {
            $this->setMerchantId($array["merchantId"]);
        } else {
            $uuid = Uuid::uuid4();
            $this->setMerchantId($uuid->toString());
        }
        $this->setContactName($array["contact_name"]);
        $this->setEmailAddress($array["email_address"]);
        $this->setPhoneNumber($array["phone_number"]);
        $this->setStreet($array["street"]);
        $this->setPostalCode($array["postal_code"]);
        $this->setLocality($array["locality"]);
        $this->setCountry($array["country"]);
        $this->setSiret($array["siret"]);
        $this->setVat($array["vat"]);
        $this->setAdditionalNotes($array["additional_notes"]);
        $this->setStatus($array["status"]);
        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["merchantId"] = $this->getMerchantId();
        $array["contact_name"] = $this->getContactName();
        $array["email_address"] = $this->getEmailAddress();
        $array["phone_number"] = $this->getPhoneNumber();
        $array["street"] = $this->getStreet();
        $array["postal_code"] = $this->getPostalCode();
        $array["locality"] = $this->getLocality();
        $array["country"] = $this->getCountry();
        $array["siret"] = $this->getSiret();
        $array["vat"] = $this->getVat();
        $array["additional_notes"] = $this->getAdditionalNotes();
        $array["status"] = $this->getStatus();

        return $array;
    }
}
