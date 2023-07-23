<?php

declare(strict_types=1);

namespace App\Entity;

use App\Config;
use App\Enum\Facility;
use App\Enum\Priority;
use App\Repository\SystemEventsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: SystemEventsRepository::class)]
#[ORM\Table(name: 'SystemEvents')]
class SystemEvents
{
    #[Groups(Config::GROUP_API)]
    #[ORM\Column(name: 'ID', type: Types::INTEGER, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(name: 'CustomerID', type: Types::BIGINT, nullable: true)]
    private ?int $customerId = null;

    #[ORM\Column(name: 'ReceivedAt', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $receivedAt = null;

    #[Groups(Config::GROUP_API)]
    #[SerializedName('date')]
    #[ORM\Column(name: 'DeviceReportedTime', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deviceReportedTime = null;

    #[ORM\Column(name: 'Facility', type: Types::SMALLINT, nullable: true)]
    private ?int $facility = null;

    #[ORM\Column(name: 'Priority', type: Types::SMALLINT, nullable: true)]
    private ?int $priority = null;

    #[Groups(Config::GROUP_API)]
    #[SerializedName('host')]
    #[ORM\Column(name: 'FromHost', type: Types::STRING, length: 60, nullable: true)]
    private ?string $fromHost = null;

    #[Groups(Config::GROUP_API)]
    #[ORM\Column(name: 'Message', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(name: 'NTSeverity', type: Types::INTEGER, nullable: true)]
    private ?int $ntSeverity = null;

    #[ORM\Column(name: 'Importance', type: Types::INTEGER, nullable: true)]
    private ?int $importance = null;

    #[ORM\Column(name: 'EventSource', type: Types::STRING, length: 60, nullable: true)]
    private ?string $eventSource = null;

    #[ORM\Column(name: 'EventUser', type: Types::STRING, length: 60, nullable: true)]
    private ?string $eventUser = null;

    #[ORM\Column(name: 'EventCategory', type: Types::INTEGER, nullable: true)]
    private ?int $eventCategory = null;

    #[ORM\Column(name: 'EventID', type: Types::INTEGER, nullable: true)]
    private ?int $eventId = null;

    #[ORM\Column(name: 'EventBinaryData', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $eventBinaryData = null;

    #[ORM\Column(name: 'MaxAvailable', type: Types::INTEGER, nullable: true)]
    private ?int $maxAvailable = null;

    #[ORM\Column(name: 'CurrUsage', type: Types::INTEGER, nullable: true)]
    private ?int $currUsage = null;

    #[ORM\Column(name: 'MinUsage', type: Types::INTEGER, nullable: true)]
    private ?int $minUsage = null;

    #[ORM\Column(name: 'MaxUsage', type: Types::INTEGER, nullable: true)]
    private ?int $maxUsage = null;

    #[ORM\Column(name: 'InfoUnitID', type: Types::INTEGER, nullable: true)]
    private ?int $infoUnitId = null;

    #[Groups(Config::GROUP_API)]
    #[SerializedName('tag')]
    #[ORM\Column(name: 'SysLogTag', type: Types::STRING, length: 60, nullable: true)]
    private ?string $sysLogTag = null;

    #[ORM\Column(name: 'EventLogType', type: Types::STRING, length: 60, nullable: true)]
    private ?string $eventLogType = null;

    #[ORM\Column(name: 'GenericFileName', type: Types::STRING, length: 60, nullable: true)]
    private ?string $genericFileName = null;

    #[ORM\Column(name: 'SystemID', type: Types::INTEGER, nullable: true)]
    private ?int $systemId = null;

    #[Groups(Config::GROUP_API)]
    #[SerializedName('priorityName')]
    public function getPriorityName(): ?string
    {
        return Priority::tryFrom($this->priority)?->name;
    }

    #[Groups(Config::GROUP_API)]
    #[SerializedName('priorityBadgeBg')]
    public function getPriorityBadgeBg(): string
    {
        return Priority::tryFrom($this->priority)?->badge() ?? 'secondary';
    }

    #[Groups(Config::GROUP_API)]
    #[SerializedName('facilityName')]
    public function getFacilityName(): ?string
    {
        return Facility::tryFrom($this->facility)?->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(?int $customerId): static
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getReceivedAt(): ?\DateTimeImmutable
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(?\DateTimeImmutable $receivedAt): static
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getDeviceReportedTime(): ?\DateTimeImmutable
    {
        return $this->deviceReportedTime;
    }

    public function setDeviceReportedTime(?\DateTimeImmutable $deviceReportedTime): static
    {
        $this->deviceReportedTime = $deviceReportedTime;

        return $this;
    }

    public function getFacility(): ?int
    {
        return $this->facility;
    }

    public function setFacility(?int $facility): static
    {
        $this->facility = $facility;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getFromHost(): ?string
    {
        return $this->fromHost;
    }

    public function setFromHost(?string $fromHost): static
    {
        $this->fromHost = $fromHost;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getNtSeverity(): ?int
    {
        return $this->ntSeverity;
    }

    public function setNtSeverity(?int $ntSeverity): static
    {
        $this->ntSeverity = $ntSeverity;

        return $this;
    }

    public function getImportance(): ?int
    {
        return $this->importance;
    }

    public function setImportance(?int $importance): static
    {
        $this->importance = $importance;

        return $this;
    }

    public function getEventSource(): ?string
    {
        return $this->eventSource;
    }

    public function setEventSource(?string $eventSource): static
    {
        $this->eventSource = $eventSource;

        return $this;
    }

    public function getEventUser(): ?string
    {
        return $this->eventUser;
    }

    public function setEventUser(?string $eventUser): static
    {
        $this->eventUser = $eventUser;

        return $this;
    }

    public function getEventCategory(): ?int
    {
        return $this->eventCategory;
    }

    public function setEventCategory(?int $eventCategory): static
    {
        $this->eventCategory = $eventCategory;

        return $this;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(?int $eventId): static
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getEventBinaryData(): ?string
    {
        return $this->eventBinaryData;
    }

    public function setEventBinaryData(?string $eventBinaryData): static
    {
        $this->eventBinaryData = $eventBinaryData;

        return $this;
    }

    public function getMaxAvailable(): ?int
    {
        return $this->maxAvailable;
    }

    public function setMaxAvailable(?int $maxAvailable): static
    {
        $this->maxAvailable = $maxAvailable;

        return $this;
    }

    public function getCurrUsage(): ?int
    {
        return $this->currUsage;
    }

    public function setCurrUsage(?int $currUsage): static
    {
        $this->currUsage = $currUsage;

        return $this;
    }

    public function getMinUsage(): ?int
    {
        return $this->minUsage;
    }

    public function setMinUsage(?int $minUsage): static
    {
        $this->minUsage = $minUsage;

        return $this;
    }

    public function getMaxUsage(): ?int
    {
        return $this->maxUsage;
    }

    public function setMaxUsage(?int $maxUsage): static
    {
        $this->maxUsage = $maxUsage;

        return $this;
    }

    public function getInfoUnitId(): ?int
    {
        return $this->infoUnitId;
    }

    public function setInfoUnitId(?int $infoUnitId): static
    {
        $this->infoUnitId = $infoUnitId;

        return $this;
    }

    public function getSysLogTag(): ?string
    {
        return $this->sysLogTag;
    }

    public function setSysLogTag(?string $sysLogTag): static
    {
        $this->sysLogTag = $sysLogTag;

        return $this;
    }

    public function getEventLogType(): ?string
    {
        return $this->eventLogType;
    }

    public function setEventLogType(?string $eventLogType): static
    {
        $this->eventLogType = $eventLogType;

        return $this;
    }

    public function getGenericFileName(): ?string
    {
        return $this->genericFileName;
    }

    public function setGenericFileName(?string $genericFileName): static
    {
        $this->genericFileName = $genericFileName;

        return $this;
    }

    public function getSystemId(): ?int
    {
        return $this->systemId;
    }

    public function setSystemId(?int $systemId): static
    {
        $this->systemId = $systemId;

        return $this;
    }
}
