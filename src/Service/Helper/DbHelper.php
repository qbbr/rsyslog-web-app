<?php

declare(strict_types=1);

namespace App\Service\Helper;

use Doctrine\ORM\EntityManagerInterface;

class DbHelper
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function getVersion(): string
    {
        return $this->em->getConnection()->executeQuery('SELECT VERSION()')->fetchOne();
    }
}
