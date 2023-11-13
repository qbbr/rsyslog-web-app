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

    public function getSize(string $table = 'SystemEvents'): string
    {
        return $this->em->getConnection()->executeQuery("
            SELECT round(((data_length + index_length) / 1024 / 1024), 2) AS size
            FROM information_schema.TABLES
            WHERE table_name = '{$table}'
        ")->fetchOne();
    }
}
