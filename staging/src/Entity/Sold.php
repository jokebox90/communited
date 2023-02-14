<?php

namespace App\Entity;

use App\Repository\SoldRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: SoldRepository::class)]
#[ORM\Table("shop_sold")]
#[ORM\Index(name: "sold_idx", columns: ["order_id", "price_id"])]
class Sold
{
    #[ORM\Id]
    #[ORM\Column(length: 36, type: Types::STRING)]
    private ?string $uniqueId = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "solds")]
    #[ORM\JoinColumn(name: "order_id", referencedColumnName: "unique_id", nullable: false)]
    private Order|null $order = null;

    #[ORM\ManyToOne(targetEntity: Price::class)]
    #[ORM\JoinColumn(name: "price_id", referencedColumnName: "unique_id", nullable: false)]
    private Price|null $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

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

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

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

    public function exchangeArray(array $array): self
    {
        if (in_array("uniqueId", array_keys($array))) {
            $this->setUniqueId($array["uniqueId"]);
        } else {
            $uuid = Uuid::uuid4();
            $this->setUniqueId($uuid->toString());
        }

        $this->setAdditionalNotes($array["additionalNotes"]);

        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["orderId"] = $this->getOrder()->getUniqueId();
        $array["priceId"] = $this->getPrice()->getUniqueId();
        $array["additionalNotes"] = $this->getAdditionalNotes();

        return $array;
    }
}
