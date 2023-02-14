<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Table("shop_payments")]
#[ORM\Index(name: "payment_idx", columns: ["unique_id", "order_id", "customer_id"])]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 36)]
    private ?string $orderId = null;

    #[ORM\Column(length: 36)]
    private ?string $customerId = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $userAgent = null;

    #[ORM\Column(length: 60)]
    private ?string $userIP = null;

    #[ORM\Column(length: 30)]
    private ?string $cardName = null;

    #[ORM\Column(length: 30)]
    private ?string $cardNumber = null;

    #[ORM\Column(length: 20)]
    private ?string $cardType = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "unique_id")]
    private Customer|null $customer = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "Payments")]
    #[ORM\JoinColumn(name: "order_id", referencedColumnName: "unique_id", nullable: false)]
    private Order|null $order = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

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

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getUserIP(): ?string
    {
        return $this->userIP;
    }

    public function setUserIP(string $userIP): self
    {
        $this->userIP = $userIP;

        return $this;
    }

    public function getCardName(): ?string
    {
        return $this->cardName;
    }

    public function setCardName(string $cardName): self
    {
        $this->cardName = $cardName;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardType(): ?string
    {
        return $this->cardType;
    }

    public function setCardType(string $cardType): self
    {
        $this->cardType = $cardType;

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

    public function exchangeArray(array $array): self
    {
        if (in_array("uniqueId", array_keys($array))) {
            $this->setUniqueId($array["uniqueId"]);
        } else {
            $uuid = Uuid::uuid4();
            $this->setUniqueId($uuid->toString());
        }

        $this->setAmount($array["amount"]);
        $this->setUserAgent($array["userAgent"]);
        $this->setUserIP($array["userIP"]);
        $this->setCardName($array["cardName"]);
        $this->setCardNumber($array["cardNumber"]);
        $this->setCardType($array["cardType"]);
        $this->setStatus($array["additionalNotes"]);
        $this->setCreatedAt(DateTime::createFromFormat(DateTime::ATOM, $array["createdAt"]));
        $this->setStatus($array["status"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["id"] = $this->getId();
        $array["uniqueId"] = $this->getUniqueId();
        $array["orderId"] = $this->getOrder()->getUniqueId();
        $array["customerId"] = $this->getCustomer()->getUniqueId();
        $array["amount"] = $this->getAmount();
        $array["userAgent"] = $this->getUserAgent();
        $array["userIP"] = $this->getUserIP();
        $array["cardName"] = $this->getCardName();
        $array["cardNumber"] = $this->getCardNumber();
        $array["cardType"] = $this->getCardType();
        $array["additionalNotes"] = $this->getAdditionalNotes();
        $array["createdAt"] = $this->getCreatedAt()->format(DateTime::ATOM);
        $array["status"] = $this->getStatus();

        return $array;
    }
}
