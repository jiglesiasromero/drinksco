<?php
declare(strict_types=1);

namespace App\System\Infrastructure;

use Doctrine\DBAL\Connection;

abstract class DbalRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    protected function connection(): Connection
    {
        return $this->connection;
    }
}
