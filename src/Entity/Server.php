<?php

namespace App\Entity;

use App\Repository\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
class Server
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $assetId = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'server', targetEntity: ServerRamModule::class, orphanRemoval: true)]
    private Collection $serverRamModules;

    public function __construct()
    {
        $this->serverRamModules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetId(): ?int
    {
        return $this->assetId;
    }

    public function setAssetId(int $assetId): self
    {
        $this->assetId = $assetId;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, ServerRamModule>
     */
    public function getServerRamModules(): Collection
    {
        return $this->serverRamModules;
    }

    public function addServerRamModule(ServerRamModule $serverRamModule): self
    {
        if (!$this->serverRamModules->contains($serverRamModule)) {
            $this->serverRamModules->add($serverRamModule);
            $serverRamModule->setServer($this);
        }

        return $this;
    }

    public function removeRamId(ServerRamModule $ramId): self
    {
        if ($this->ramId->removeElement($ramId)) {
            // set the owning side to null (unless already changed)
            if ($ramId->getServer() === $this) {
                $ramId->setServer(null);
            }
        }

        return $this;
    }
}
