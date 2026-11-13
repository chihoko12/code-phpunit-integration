<?php

namespace App\Tests\Integration\Repository;

use App\Entity\LockDown;
use App\Repository\LockDownRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LockDownRepositoryTest extends KernelTestCase
{
    public function testIsInLockDownWithNoLockDownRows(): void
    {
        self::bootKernel();

        $lockDownRepository = self::getContainer()->get(LockDownRepository::class);
        assert($lockDownRepository instanceof LockDownRepository);
        $this->assertFalse($lockDownRepository->isInLockDown());
    }

}
