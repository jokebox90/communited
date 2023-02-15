<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table("shop_customers")]
#[ORM\Index(name: "customer_idx", columns: ["status"])]
class Customer
{
    const GRADE_CONTACT    = "contact";
    const GRADE_VISITOR    = "visiteur";
    const GRADE_MEMBER     = "membre";
    const GRADE_AMBASSADOR = "ambassadeur";
    const GRADE_LEGEND    = "fondateur";
    const AVAILABLE_GRADES = [
        self::GRADE_CONTACT,
        self::GRADE_VISITOR,
        self::GRADE_MEMBER,
        self::GRADE_AMBASSADOR,
        self::GRADE_LEGEND,
    ];

    const STATUS_ACTIVE    = "actif";
    const STATUS_INACTIVE  = "inactif";
    const AVAILABLE_STATUS = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
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

    #[ORM\Column(length: 20)]
    private ?string $grade = null;

    #[ORM\Column(length: 30)]
    private ?string $firstName = null;

    #[ORM\Column(length: 30)]
    private ?string $lastName = null;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 60, unique: true)]
    private ?string $emailAddress = null;

    #[ORM\OneToMany(targetEntity: Address::class, mappedBy: "customer", cascade: ["persist"])]
    private Collection $postalAdress;

    public function __construct() {
        $this->postalAdress = new ArrayCollection();
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

    public function getAddress(): Collection
    {
        return $this->postalAdress;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->postalAdress->contains($address)) {
            $this->postalAdress->add($address);
            $address->setCustomer($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->postalAdress->contains($address)) {
            $this->postalAdress->removeElement($address);
            $address->setCustomer(null);
        }

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

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

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

    public function exchangeArray(array $array): self
    {
        if (in_array("uniqueId", array_keys($array))) {
            $this->setUniqueId($array["uniqueId"]);
        } else {
            $uuid = Uuid::uuid4();
            $this->setUniqueId($uuid->toString());
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

        $this->setFirstName($array["firstName"]);
        $this->setLastName($array["lastName"]);
        $this->setGrade($array["grade"]);
        $this->setPhoneNumber($array["phoneNumber"]);
        $this->setEmailAddress($array["emailAddress"]);
        $this->setBirthDate(DateTime::createFromFormat("Y-m-d", $array["birthDate"]));
        $this->setStatus($array["status"]);

        for ($i = 0; $i < count($array["Address"]); $i++) {
            $addressArray = $array["Address"][$i];

            $predicate =
                function  (int $key, Address $value) use ($addressArray) {
                    return $addressArray["uniqueId"] === $value->getUniqueId();
                };

            if ($this->postalAdress->exists($predicate)) {
                $address = $this->postalAdress->findFirst($predicate);
            } else {
                $address = new Address();
            }

            $address->exchangeArray($addressArray);
            $this->addAddress($address);
        }

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["firstName"] = $this->getFirstName();
        $array["lastName"] = $this->getLastName();
        $array["grade"] = $this->getGrade();
        $array["phoneNumber"] = $this->getPhoneNumber();
        $array["birthDate"] = $this->getBirthDate()->format("Y-m-d");
        $array["emailAddress"] = $this->getEmailAddress();
        $array["status"] = $this->getStatus();
        $array["Address"] = $this->getAddress()
            ->map(function (Address $address) {
                return $address->populateArray();
            });

        return $array;
    }
}
