<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $reference;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention, la date d'arrivée doit être au bon format !")
     * @Assert\GreaterThan("today", message="la date d'arrivée doit être ultérieur à la date d'aujourd'hui", groups={"edit"})
     * @Assert\GreaterThan("+24 hours", message="La date d'arrivé doit être supérieure à la date courante + 24h.", groups={"edit"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention, la date de départ doit être au bon format !")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de retour doit être plus éloignée que la date de d'arrivée" )
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking", inversedBy="bookings")
     */
    private $parking;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Advantage", inversedBy="bookings")
     */
    private $advantages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plaque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberVolAller;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberVolRetour;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * Callback appelé à chaque fois qu'on créé une réservation
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist() {
        if (empty($this->type)) {
            $this->type = "En ligne";
        }
        
        if (empty($this->reference)) {
            $this->reference = new \DateTime();
        }

        if ($this->getDuration() === 1 || $this->getDuration() === 2 || $this->getDuration() === 3) {
            $this->amount = 24;
        }

        if (empty($this->amount)) {
            $this->amount = $this->parking->getPrice() * $this->getDuration();
        }
        if (empty($this->modele)) {
            $this->modele = "";
        }
        if (empty($this->plaque)) {
            $this->plaque = "";
        }
        if (empty($this->destination)) {
            $this->destination = "";
        }
        if (empty($this->marque)) {
            $this->marque = "";
        }
        if (empty($this->numberVolAller)) {
            $this->numberVolAller = "";
        }
        if (empty($this->numberVolRetour)) {
            $this->numberVolRetour = "";
        }
        if (empty($this->status)) {
            $this->status = false;
        }
    }

    // Récupération du nombre de jour entre l'arrivé et le départ
    public function getDuration() {
        // Methode DateTime
        $diff = $this->endDate->diff($this->startDate);
        return $diff->days;
    }

    public function __construct()
    {
        $this->advantages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReference(): ?\DateTimeInterface
    {
        return $this->reference;
    }

    public function setReference(\DateTimeInterface $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getParking(): ?Parking
    {
        return $this->parking;
    }

    public function setParking(?Parking $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * @return Collection|Advantage[]
     */
    public function getAdvantages(): Collection
    {
        return $this->advantages;
    }

    public function addAdvantage(Advantage $advantage): self
    {
        if (!$this->advantages->contains($advantage)) {
            $this->advantages[] = $advantage;
        }

        return $this;
    }

    public function removeAdvantage(Advantage $advantage): self
    {
        if ($this->advantages->contains($advantage)) {
            $this->advantages->removeElement($advantage);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getPlaque(): ?string
    {
        return $this->plaque;
    }

    public function setPlaque(string $plaque): self
    {
        $this->plaque = $plaque;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getNumberVolAller(): ?string
    {
        return $this->numberVolAller;
    }

    public function setNumberVolAller(string $numberVolAller): self
    {
        $this->numberVolAller = $numberVolAller;

        return $this;
    }

    public function getNumberVolRetour(): ?string
    {
        return $this->numberVolRetour;
    }

    public function setNumberVolRetour(string $numberVolRetour): self
    {
        $this->numberVolRetour = $numberVolRetour;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
