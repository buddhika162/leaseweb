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
    private ?Server $serverId = null;

    #[ORM\ManyToOne(inversedBy: 'serverRamModules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RamModule $ramId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServerId(): ?Server
    {
        return $this->serverId;
    }

    public function setServerId(?Server $serverId): self
    {
        $this->serverId = $serverId;

        return $this;
    }

    public function getRamId(): ?RamModule
    {
        return $this->ramId;
    }

    public function setRamId(?RamModule $ramId): self
    {
        $this->ramId = $ramId;

        return $this;
    }
}
