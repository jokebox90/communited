<?php

namespace App\Entity;

use App\Repository\PostRepository;
use App\Service\UniqueIdGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table("blog_posts")]
class Post
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private ?string $uniqueId = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $title;

    #[ORM\Column(length: 510, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "text")]
    private ?string $content;

    #[ORM\Column(type: "datetime", length: 255)]
    private $createdAt;

    #[ORM\Column(type: "datetime", length: 255)]
    private $updatedAt;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "posts")]
    #[ORM\JoinTable(name: "blog_categorized")]
    #[ORM\JoinColumn(name: "post_id", referencedColumnName: "unique_id")]
    #[ORM\InverseJoinColumn(name: "category_id", referencedColumnName: "unique_id")]
    private $categories;

    public function __construct()
    {
        $this->uniqueId = (new UniqueIdGenerator())->create();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->categories = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addPost($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removePost($this);
        }

        return $this;
    }
}
