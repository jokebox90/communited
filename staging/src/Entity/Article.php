<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Index(name: "article_idx", columns: ["status"])]
class Article
{
    const STATUS_ACTIVE    = "actif";
    const STATUS_INACTIVE  = "inactif";
    const AVAILABLE_STATUS = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $available = null;

    #[ORM\OneToMany(targetEntity: ArticlePrice::class, mappedBy: "article", cascade: ["persist"])]
    private Collection $prices;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $tags = [];

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getAvailable(): ?int
    {
        return $this->available;
    }

    public function setAvailable(int $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(ArticlePrice $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices->add($price);
            $price->setArticle($this);
        }

        return $this;
    }

    public function removePrice(ArticlePrice $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            $price->setArticle(null);
        }

        return $this;
    }


    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

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

        $this->setTitle($array["title"]);
        $this->setDescription($array["description"]);
        $this->setAvailable($array["available"]);
        $this->setTags($array["tags"]);
        $this->setStatus($array["status"]);

        for ($i = 0; $i < count($array["prices"]); $i++) {
            $priceArray = $array["prices"][$i];

            $predicate =
                function  (int $key, ArticlePrice $value) use ($priceArray) {
                    return $priceArray["uniqueId"] === $value->getUniqueId();
                };

            if ($this->prices->exists($predicate)) {
                $price = $this->prices->findFirst($predicate);
            } else {
                $price = new ArticlePrice();
            }

            $price->exchangeArray($priceArray);
            $this->addPrice($price);
        }
        return $this;
    }

    public function populateArray(array $array = []): array
    {
        $array["uniqueId"] = $this->getUniqueId();
        $array["title"] = $this->getTitle();
        $array["description"] = $this->getDescription();
        $array["available"] = $this->getAvailable();
        $array["tags"] = $this->getTags();
        $array["status"] = $this->getStatus();
        $array["prices"] = $this->getPrices()
            ->map(function (ArticlePrice $price) {
                return $price->populateArray();
            });

        return $array;
    }
}
