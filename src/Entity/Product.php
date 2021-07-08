<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     cacheHeaders={"max_age"=3600, "shared_max_age"=3600, "vary"={"Authorization"}},
 *     paginationItemsPerPage = 5,
 *     normalizationContext={"groups"={"read:Product:collection"}},
 *     collectionOperations={
 *         "get"={
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *             }
 *          }
 *     },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"read:Product:collection","read:Product:item"}},
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *             }
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:Product:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:Product:collection"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read:Product:item"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read:Product:item"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:Product:item"})
     */
    private $brand;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:Product:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:Product:item"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }
}
