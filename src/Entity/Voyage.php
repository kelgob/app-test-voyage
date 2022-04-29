<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoyageRepository::class)]
class Voyage
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string')]
    private ?string $name;

    #[Assert\Valid]
    #[Assert\Count(min: 1, minMessage: "Veuillez ajouter au moins 1 étape à votre voyage")]
    #[ORM\OneToMany(mappedBy: 'voyage', targetEntity: Etape::class, cascade: ['persist','remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['stepOrder' => 'ASC'])]
    private Collection $etapes;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes[] = $etape;
            $etape->setVoyage($this);
            $etape->setStepOrder($this->etapes->count());
        }

        return $this;
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getVoyage() === $this) {
                $etape->setVoyage(null);
            }
        }

        return $this;
    }
}
