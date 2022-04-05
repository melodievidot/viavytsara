<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image_alt;

    /**
     * @ORM\OneToMany(targetEntity=Soin::class, mappedBy="categorie", orphanRemoval=true)
     */
    private $soin;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, mappedBy="categorie")
     */
    private $reservations;

    public function __construct()
    {
        $this->soin = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->Titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getImageAlt(): ?string
    {
        return $this->Image_alt;
    }

    public function setImageAlt(string $Image_alt): self
    {
        $this->Image_alt = $Image_alt;

        return $this;
    }

    /**
     * @return Collection|Soin[]
     */
    public function getSoin(): Collection
    {
        return $this->soin;
    }

    public function addSoin(Soin $soin): self
    {
        if (!$this->soin->contains($soin)) {
            $this->soin[] = $soin;
            $soin->setCategorie($this);
        }

        return $this;
    }

    public function removeSoin(Soin $soin): self
    {
        if ($this->soin->removeElement($soin)) {
            // set the owning side to null (unless already changed)
            if ($soin->getCategorie() === $this) {
                $soin->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->addCategorie($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeCategorie($this);
        }

        return $this;
    }
}
