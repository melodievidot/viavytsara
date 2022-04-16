<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=ProduitBoutique::class, mappedBy="commande")
     */
    private $produitBoutiques;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="commandes")
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    public function __construct()
    {
        $this->produitBoutiques = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ProduitBoutique>
     */
    public function getProduitBoutiques(): Collection
    {
        return $this->produitBoutiques;
    }

    public function addProduitBoutique(ProduitBoutique $produitBoutique): self
    {
        if (!$this->produitBoutiques->contains($produitBoutique)) {
            $this->produitBoutiques[] = $produitBoutique;
            $produitBoutique->addCommande($this);
        }

        return $this;
    }

    public function removeProduitBoutique(ProduitBoutique $produitBoutique): self
    {
        if ($this->produitBoutiques->removeElement($produitBoutique)) {
            $produitBoutique->removeCommande($this);
        }

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}
