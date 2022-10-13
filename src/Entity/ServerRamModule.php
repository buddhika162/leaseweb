<?php

namespace App\Entity;

use App\Repository\ServerRamModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerRamModuleRepository::class)]
class ServerRamModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serverRamModules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Server $server = null;

    #[ORM\ManyToOne(inversedBy: 'serverRamModules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RamModule $ram = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $serverId): self
    {
        $this->server = $serverId;

        return $this;
    }

    public function getRam(): ?RamModule
    {
        return $this->ram;
    }

    public function setRam(?RamModule $ramId): self
    {
        $this->ram = $ramId;

        return $this;
    }
}
