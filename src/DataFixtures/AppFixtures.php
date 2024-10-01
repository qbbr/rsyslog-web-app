<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SystemEvents;
use App\Enum\Facility;
use App\Enum\Priority;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const HOSTS = ['SRV1', 'CLNT2', 'ROUTER2', 'DNS_SRV'];
    private const TAGS = ['kernel:', 'user:', 'systemd[1203]', 'pipewire[1211]:'];

    public function load(ObjectManager $manager): void
    {
        $n = 5000;
        for ($i = 0; $i < $n; ++$i) {
            $event = new SystemEvents();
            $event->setPriority(Priority::tryFrom(array_rand(Priority::allValues()))->value);
            $event->setDeviceReportedTime((new \DateTimeImmutable())->modify(\sprintf('-%d minute', $n - $i)));
            $event->setFacility(Facility::tryFrom(array_rand(Facility::allValues()))->value);
            $event->setFromHost(self::HOSTS[array_rand(self::HOSTS)]);
            $event->setSysLogTag(self::TAGS[array_rand(self::TAGS)]);
            $event->setMessage('Lorem Ipsum is simply dummy text of the printing and typesetting industry.');

            $manager->persist($event);
        }

        $manager->flush();
    }
}
