<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SystemEventsPropertiesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SystemEventsPropertiesRepository::class)]
#[ORM\Table(name: 'SystemEventsProperties')]
class SystemEventsProperties
{
    #[ORM\Column(name: 'ID', type: Types::INTEGER, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'SystemEventID', type: Types::INTEGER, nullable: true)]
    private ?int $systemEventId = null;

    #[ORM\Column(name: 'ParamName', type: Types::STRING, length: 255, nullable: true)]
    private ?string $paramName = null;

    #[ORM\Column(name: 'ParamValue', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $paramValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSystemEventId(): ?int
    {
        return $this->systemEventId;
    }

    public function setSystemEventId(?int $systemEventId): static
    {
        $this->systemEventId = $systemEventId;

        return $this;
    }

    public function getParamName(): ?string
    {
        return $this->paramName;
    }

    public function setParamName(?string $paramName): static
    {
        $this->paramName = $paramName;

        return $this;
    }

    public function getParamValue(): ?string
    {
        return $this->paramValue;
    }

    public function setParamValue(?string $paramValue): static
    {
        $this->paramValue = $paramValue;

        return $this;
    }
}
