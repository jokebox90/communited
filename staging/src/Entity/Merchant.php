<?php

namespace App\Entity;

use App\Repository\MerchantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Ramsey\Uuid\Uuid;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MerchantRepository::class)]
class Merchant
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 60)]
    private ?string $companyName = null;

    #[ORM\Column(length: 60)]
    private ?string $emailAddress = null;

    #[ORM\Column(length: 60)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 120)]
    private ?string $street = null;

    #[ORM\Column(length: 10)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 60)]
    private ?string $locality = null;

    #[ORM\Column(length: 60)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 30)]
    private ?string $activity = null;

    #[ORM\OneToMany(mappedBy: 'merchant', targetEntity: MerchantContact::class)]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

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

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

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

    /**
     * @return Collection<int, MerchantContact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(MerchantContact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setMerchant($this);
        }

        return $this;
    }

    public function removeContact(MerchantContact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getMerchant() === $this) {
                $contact->setMerchant(null);
            }
        }

        return $this;
    }

    public function exchangeArray(array $array):self
    {
        if (in_array("uniqueId", array_keys($array))) {
            $this->setUniqueId($array["uniqueId"]);
        } else {
            $uuid = Uuid::uuid4();
            $this->setUniqueId($uuid->toString());
        }
        $this->setCompanyName($array["company_name"]);
        $this->setEmailAddress($array["email_address"]);
        $this->setPhoneNumber($array["phone_number"]);
        $this->setStreet($array["street"]);
        $this->setPostalCode($array["postal_code"]);
        $this->setLocality($array["locality"]);
        $this->setCountry($array["country"]);
        $this->setRegistrationDate($array["registration_date"]);
        $this->setActivity($array["activity"]);
        $this->setWebsite($array["website"]);
        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["email_address"] = $this->getEmailAddress();
        $array["phone_number"] = $this->getPhoneNumber();
        $array["street"] = $this->getStreet();
        $array["postal_code"] = $this->getPostalCode();
        $array["locality"] = $this->getLocality();
        $array["country"] = $this->getCountry();
        $array["registration_date"] = $this->getRegistrationDate();
        $array["activity"] = $this->getActivity();
        $array["website"] = $this->getWebsite();

        return $array;
    }

}
