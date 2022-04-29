<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EtapeRepository;
use App\Util\ChoiceList;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['voyage', 'departure'], message: "La ville de départ {{ value }} ne peut pas être utilisée plusieurs fois", errorPath: 'departure')]
#[UniqueEntity(fields: ['voyage', 'arrival'], message: "La ville d'arrivée {{ value }} ne peut pas être utilisée plusieurs fois", errorPath: 'arrival')]
#[ORM\Entity(repositoryClass: EtapeRepository::class)]
class Etape
{
    public const TYPE_BUS = 'bus';
    public const TYPE_CAR = 'car';
    public const TYPE_PLANE = 'plane';
    public const TYPE_TRAIN = 'train';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Voyage::class, inversedBy: 'etapes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voyage $voyage;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $departure;

    #[Assert\NotBlank]
    #[Assert\NotEqualTo(propertyPath: 'departure', message: "Les villes de départ et d'arrivée ne doivent pas être identiques")]
    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $arrival;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [ChoiceList::class, 'getEtapeTypes'])]
    #[ORM\Column(type: 'string')]
    private ?string $type;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string')]
    private ?string $number;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $seat;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $gate;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $baggageDrop;

    #[ORM\Column(type: 'smallint')]
    private ?int $stepOrder;

    public function getId(): ?Uuid
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

    public function getVoyage(): ?Voyage
    {
        return $this->voyage;
    }

    public function setVoyage(?Voyage $voyage): self
    {
        $this->voyage = $voyage;

        return $this;
    }

    public function getDeparture(): ?Ville
    {
        return $this->departure;
    }

    public function setDeparture(?Ville $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?Ville
    {
        return $this->arrival;
    }

    public function setArrival(?Ville $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
    
    public function getSeat(): ?string
    {
        return $this->seat;
    }

    public function setSeat(?string $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getGate(): ?string
    {
        return $this->gate;
    }

    public function setGate(?string $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    public function getBaggageDrop(): ?string
    {
        return $this->baggageDrop;
    }

    public function setBaggageDrop(?string $baggageDrop): self
    {
        $this->baggageDrop = $baggageDrop;

        return $this;
    }

    public function getStepOrder(): ?int
    {
        return $this->stepOrder;
    }

    public function setStepOrder(int $stepOrder): self
    {
        $this->stepOrder = $stepOrder;

        return $this;
    }
}
