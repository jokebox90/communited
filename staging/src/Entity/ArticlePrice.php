<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: PriceRepository::class)]
#[ORM\Index(name: "article_price_idx", columns: ["article_id", "status"])]
class ArticlePrice
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(length: 36, unique: false)]
    private ?string $articleId = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 120)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 20)]
    private ?string $frequency = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: "prices")]
    #[ORM\JoinColumn(name: "article_id", referencedColumnName: "unique_id")]
    private Article|null $article = null;

    public function getUniqueId(): ?string
    {
        return $this->uniqueId;
    }

    public function setUniqueId(string $uniqueId): self
    {
        $this->uniqueId = $uniqueId;

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

    public function getArticleId(): ?string
    {
        return $this->articleId;
    }

    public function setArticleId(string $articleId): self
    {
        $this->articleId = $articleId;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

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

        $this->setArticleId($array["articleId"]);
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
        $array["articleId"] = $this->getArticleId();
        $array["description"] = $this->getDescription();
        $array["amount"] = $this->getAmount();
        $array["duration"] = $this->getDuration();
        $array["frequency"] = $this->getFrequency();
        $array["status"] = $this->getStatus();

        return $array;
    }
}
