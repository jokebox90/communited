<?php

namespace App\Entity;

use App\Repository\CheckoutRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CheckoutRepository::class)]
#[ORM\Index(name: "checkout_idx", columns: ["customer_id", "address_id"])]
class Checkout
{
    const STATUS_OPEN        = "ouverte";
    const STATUS_VALIDATED   = "valide";
    const STATUS_PROCESSING  = "traitement";
    const STATUS_PAUSED      = "pause";
    const STATUS_STOPPED     = "arret";
    const STATUS_TERMINATED  = "cloture";
    const AVAILABLE_STATUS = [
        self::STATUS_OPEN,
        self::STATUS_VALIDATED,
        self::STATUS_PROCESSING,
        self::STATUS_PAUSED,
        self::STATUS_STOPPED,
        self::STATUS_TERMINATED,
    ];

    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 36)]
    private ?string $customerId = null;

    #[ORM\Column(length: 36)]
    private ?string $addressId = null;

    #[ORM\Column(length: 60)]
    private ?string $reference = null;

    #[ORM\Column(length: 60)]
    private ?string $email_address = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additional_notes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: CheckoutItem::class, mappedBy: "checkout")]
    private Collection $checkoutItems;

    #[ORM\OneToMany(targetEntity: CheckoutPayment::class, mappedBy: "checkout")]
    private Collection $checkoutPayments;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "unique_id")]
    private Customer|null $customer = null;

    #[ORM\ManyToOne(targetEntity: CustomerPostalAddress::class)]
    #[ORM\JoinColumn(name: "address_id", referencedColumnName: "unique_id")]
    private CustomerPostalAddress|null $postalAddress = null;

    public function __construct() {
        $this->checkoutItems = new ArrayCollection();
        $this->checkoutPayments = new ArrayCollection();
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

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getAddressId(): ?string
    {
        return $this->addressId;
    }

    public function setAddressId(string $addressId): self
    {
        $this->addressId = $addressId;

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
        return $this->email_address;
    }

    public function setEmailAddress(string $email_address): self
    {
        $this->email_address = $email_address;

        return $this;
    }

    public function getAdditionalNotes(): ?string
    {
        return $this->additional_notes;
    }

    public function setAdditionalNotes(?string $additional_notes): self
    {
        $this->additional_notes = $additional_notes;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPostalAddress(): ?CustomerPostalAddress
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(CustomerPostalAddress $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getCheckoutItems(): Collection
    {
        return $this->checkoutItems;
    }

    public function addCheckoutItem(CheckoutItem $item): self
    {
        if (!$this->checkoutItems->contains($item)) {
            $this->checkoutItems->add($item);
        }

        return $this;
    }

    public function removeCheckoutItem(CheckoutItem $item): self
    {
        if ($this->checkoutItems->contains($item)) {
            $this->checkoutItems->removeElement($item);
        }

        return $this;
    }

    public function getCheckoutPayments(): Collection
    {
        return $this->checkoutPayments;
    }

    public function addCheckoutPayment(CheckoutPayment $payment): self
    {
        if (!$this->checkoutPayments->contains($payment)) {
            $this->checkoutPayments->add($payment);
        }

        return $this;
    }

    public function removeCheckoutPayment(CheckoutPayment $payment): self
    {
        if ($this->checkoutPayments->contains($payment)) {
            $this->checkoutPayments->removeElement($payment);
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

        $this->setCustomerId($array["customerId"]);
        $this->setAddressId($array["addressId"]);
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
        $array["customerId"] = $this->getCustomerId();
        $array["addressId"] = $this->getAddressId();
        $array["reference"] = $this->getReference();
        $array["emailAddress"] = $this->getEmailAddress();
        $array["additionalNotes"] = $this->getAdditionalNotes();
        $array["createdAt"] = $this->getCreatedAt()->format(DateTime::ATOM);
        $array["status"] = $this->getStatus();

        return $array;
    }
}
