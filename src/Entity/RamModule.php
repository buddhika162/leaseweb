<?php

namespace App\Entity;

use App\Repository\RamModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RamModuleRepository::class)]
class RamModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\OneToMany(mappedBy: 'ramId', targetEntity: ServerRamModule::class)]
    private Collection $serverRamModules;

    public function __construct()
    {
        $this->serverRamModules = new ArrayCollection();
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

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

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
            $serverRamModule->setRam($this);
        }

        return $this;
    }

    public function removeServerRamModule(ServerRamModule $serverRamModule): self
    {
        if ($this->serverRamModules->removeElement($serverRamModule)) {
            // set the owning side to null (unless already changed)
            if ($serverRamModule->getRam() === $this) {
                $serverRamModule->setRam(null);
            }
        }

        return $this;
    }
}
