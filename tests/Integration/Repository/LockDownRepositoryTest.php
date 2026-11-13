<?php

namespace App\Tests\Integration\Repository;

use App\Entity\LockDown;
use App\Enum\LockDownStatus;
use App\Repository\LockDownRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LockDownRepositoryTest extends KernelTestCase
{
    use ResetDatabase, Factories;
    public function testIsInLockDownWithNoLockDownRows(): void
    {
        self::bootKernel();

        $this->assertFalse($this->getLockDownRepository()->isInLockDown());
    }

    public function testIsInLockDownReturnsTrueIfMostRecentLockDownIsActive(): void
    {
        self::bootKernel();

        $lockDown = new LockDown();
        $lockDown->setReason('Dinos have organized their own lunch break');
        $lockDown->setCreatedAt(new \DateTimeImmutable('-1 day'));

        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        assert($entityManager instanceof EntityManagerInterface);
        $entityManager->persist($lockDown);
        $entityManager->flush();

        $this->assertTrue($this->getLockDownRepository()->isInLockDown());
    }

    private function getLockDownRepository(): LockDownRepository
    {
        return self::getContainer()->get(LockDownRepository::class);

    }
}
