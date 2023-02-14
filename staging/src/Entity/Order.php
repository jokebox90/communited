<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table("shop_orders")]
#[ORM\Index(name: "order_idx", columns: ["customer_id", "address_id"])]
class Order
{
    const STATUS_OPEN        = "ouverte";
    const STATUS_VALID       = "valide";
    const STATUS_PROCESSING  = "traitement";
    const STATUS_PAUSED      = "pause";
    const STATUS_STOPPED     = "arret";
    const STATUS_TERMINATED  = "cloture";
    const AVAILABLE_STATUS = [
        self::STATUS_OPEN,
        self::STATUS_VALID,
        self::STATUS_PROCESSING,
        self::STATUS_PAUSED,
        self::STATUS_STOPPED,
        self::STATUS_TERMINATED,
    ];

    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 60, unique: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $emailAddress = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Sold::class, mappedBy: "order", cascade: ["persist"])]
    private Collection $solds;

    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: "order", cascade: ["persist"])]
    private Collection $Payments;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "unique_id", onDelete: "SET NULL")]
    private Customer|null $customer = null;

    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(name: "address_id", referencedColumnName: "unique_id", onDelete: "SET NULL")]
    private Address|null $Address = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modifiedAt = null;

    public function __construct() {
        $this->solds = new ArrayCollection();
        $this->Payments = new ArrayCollection();
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(Address $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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

    public function getAdditionalNotes(): ?string
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes(?string $additionalNotes): self
    {
        $this->additionalNotes = $additionalNotes;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSoldItems(): Collection
    {
        return $this->solds;
    }

    public function addItemToSold(Sold $item): self
    {
        if (!$this->solds->contains($item)) {
            $this->solds->add($item);
            $item->setOrder($this);
        }

        return $this;
    }

    public function removeItemFromSold(Sold $item): self
    {
        if ($this->solds->contains($item)) {
            $this->solds->removeElement($item);
            $item->setOrder(null);
        }

        return $this;
    }

    public function getPayments(): Collection
    {
        return $this->Payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->Payments->contains($payment)) {
            $this->Payments->add($payment);
            $payment->setOrder($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->Payments->contains($payment)) {
            $this->Payments->removeElement($payment);
            $payment->setOrder(null);
        }

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

        $this->setReference($array["reference"]);
        $this->setEmailAddress($array["emailAddress"]);
        $this->setAdditionalNotes($array["additionalNotes"]);
        $this->setCreatedAt(DateTime::createFromFormat(DateTime::ATOM, $array["createdAt"]));
        $this->setStatus($array["status"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["customerId"] = $this->getCustomer()->getUniqueId();
        $array["addressId"] = $this->getAddress()->getUniqueId();
        $array["reference"] = $this->getReference();
        $array["emailAddress"] = $this->getEmailAddress();
        $array["additionalNotes"] = $this->getAdditionalNotes();
        $array["createdAt"] = $this->getCreatedAt()->format(DateTime::ATOM);
        $array["status"] = $this->getStatus();
        $array["solds"] = $this->getSoldItems()
            ->map(function (Sold $item) {
                return $item->populateArray();
            });

        return $array;
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
}
