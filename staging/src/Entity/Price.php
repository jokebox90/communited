<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: PriceRepository::class)]
#[ORM\Table("shop_prices")]
#[ORM\Index(name: "price_idx", columns: ["item_id", "status"])]
class Price
{
    const STATUS_ACTIVE    = "actif";
    const STATUS_INACTIVE  = "inactif";
    const STATUS_DELETED   = "supprimé";
    const AVAILABLE_STATUS = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_DELETED,
    ];

    const FREQUENCY_DAILY    = "journalier";
    const FREQUENCY_WEEKLY   = "hebdomadaire";
    const FREQUENCY_MONTHLY  = "mensuel";
    const FREQUENCY_QUARTER  = "trimestriel";
    const FREQUENCY_SEMESTER = "semestre";
    const FREQUENCY_ANNUAL   = "annuel";
    const AVAILABLE_FREQUENCIES = [
        self::FREQUENCY_DAILY,
        self::FREQUENCY_WEEKLY,
        self::FREQUENCY_MONTHLY,
        self::FREQUENCY_QUARTER,
        self::FREQUENCY_SEMESTER,
        self::FREQUENCY_ANNUAL,
    ];

    #[ORM\Id]
    #[ORM\Column(length: 36, type: Types::STRING)]
    private ?string $uniqueId = null;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: "prices")]
    #[ORM\JoinColumn(name: "item_id", referencedColumnName: "unique_id")]
    private Item|null $item = null;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'prices')]
    #[ORM\JoinColumn(name: 'contact_id', referencedColumnName: 'unique_id', nullable: false)]
    private ?Contact $contact = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 20)]
    private ?string $frequency = null;

    #[ORM\Column(length: 120)]
    private ?string $description = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modifiedAt = null;

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

        $this->setDescription($array["description"]);
        $this->setAmount($array["amount"]);
        $this->setDuration($array["duration"]);
        $this->setFrequency($array["frequency"]);
        $this->setStatus($array["status"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["status"]          = $this->getStatus();
        $array["createdAt"]       = $this->getCreatedAt()->format(DateTime::ATOM);
        $array["modifiedAt"]      = $this->getModifiedAt()->format(DateTime::ATOM);
        $array["itemId"] = $this->getItem()->getUniqueId();
        $array["description"] = $this->getDescription();
        $array["amount"] = $this->getAmount();
        $array["duration"] = $this->getDuration();
        $array["frequency"] = $this->getFrequency();

        return $array;
    }
}
