<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read:User:collection"}},
 *     denormalizationContext={"groups"={"write:User:item"}},
 *     collectionOperations={
 *         "get"={
 *             "formats"={"jsonhal"={"application/hal+json"}},
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *              }
 *         },
 *         "post"={
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *              }
 *         }
 *     },
 *     itemOperations={
 *         "put"={
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *             }
 *         },
 *         "delete"={
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *             }
 *         },
 *         "get"={
 *             "formats"={"jsonhal"={"application/hal+json"}},
 *             "normalization_context"={"groups"={"read:User:collection","read:User:item","read:User"}},
 *             "openapi_context"={
 *                  "security"={{"bearerAuth"={}}}
 *             }
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:User:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:User:collection","read:User:item","write:User:item"})
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $mail;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:User:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:User:item"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:User:item"})
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:User:collection","read:User:item","write:User:item"})
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:User:collection","read:User:item","write:User:item"})
     * @Assert\NotBlank
     */
    private $lastName;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
