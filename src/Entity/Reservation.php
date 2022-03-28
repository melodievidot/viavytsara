<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_reservation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_paiement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="reservation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\ManyToMany(targetEntity=Soin::class, inversedBy="reservations")
     */
    private $soin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $horaire;

    /**
     * @ORM\ManyToOne(targetEntity=Calendrier::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $calendrier;

    public function __construct()
    {
        $this->soin = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDateDeReservation(): ?\DateTimeInterface
    {
        return $this->date_de_reservation;
    }

    public function setDateDeReservation(\DateTimeInterface $date_de_reservation): self
    {
        $this->date_de_reservation = $date_de_reservation;

        return $this;
    }

    public function getDateDePaiement(): ?\DateTimeInterface
    {
        return $this->date_de_paiement;
    }

    public function setDateDePaiement(\DateTimeInterface $date_de_paiement): self
    {
        $this->date_de_paiement = $date_de_paiement;

        return $this;
    }


    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection|soin[]
     */
    public function getSoin(): Collection
    {
        return $this->soin;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function addSoin(Soin $soin): self
    {
        if (!$this->soin->contains($soin)) {
            $this->soin[] = $soin;
        }

        return $this;
    }

    public function removeSoin(Soin $soin): self
    {
        $this->soin->removeElement($soin);

        return $this;
    }

    public function getHoraire(): ?\DateTimeInterface
    {
        return $this->horaire;
    }

    public function setHoraire(\DateTimeInterface $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getCalendrier(): ?Calendrier
    {
        return $this->calendrier;
    }

    public function setCalendrier(?Calendrier $calendrier): self
    {
        $this->calendrier = $calendrier;

        return $this;
    }
}
