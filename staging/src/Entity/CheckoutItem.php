<?php

namespace App\Entity;

use App\Repository\CheckoutItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: CheckoutItemRepository::class)]
#[ORM\Index(name: "checkout_item_ids", columns: ["unique_id", "checkout_id", "price_id"])]
class CheckoutItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 36)]
    private ?string $checkoutId = null;

    #[ORM\Column(length: 36)]
    private ?string $priceId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    #[ORM\ManyToOne(targetEntity: Checkout::class, inversedBy: "checkoutItems")]
    #[ORM\JoinColumn(name: "checkout_id", referencedColumnName: "unique_id", nullable: false)]
    private Checkout|null $checkout = null;

    #[ORM\ManyToOne(targetEntity: ArticlePrice::class)]
    #[ORM\JoinColumn(name: "price_id", referencedColumnName: "unique_id", nullable: false)]
    private ArticlePrice|null $price = null;

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

    public function getCheckoutId(): ?string
    {
        return $this->checkoutId;
    }

    public function setCheckoutId(string $checkoutId): self
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    public function getPriceId(): ?string
    {
        return $this->priceId;
    }

    public function setPriceId(string $priceId): self
    {
        $this->priceId = $priceId;

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

    public function getCheckout(): ?Checkout
    {
        return $this->checkout;
    }

    public function setCheckout(Checkout $checkout): self
    {
        $this->checkout = $checkout;

        return $this;
    }

    public function getPrice(): ?ArticlePrice
    {
        return $this->price;
    }

    public function setPrice(ArticlePrice $price): self
    {
        $this->price = $price;

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

        $this->setCheckoutId($array["checkoutId"]);
        $this->setPriceId($array["priceId"]);
        $this->setAdditionalNotes($array["additionalNotes"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["checkoutId"] = $this->getCheckoutId();
        $array["priceId"] = $this->getPriceId();
        $array["additionalNotes"] = $this->getAdditionalNotes();

        return $array;
    }
}
