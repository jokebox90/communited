<?php

declare(strict_types=1);

namespace Tests\Base;

use App\Entity\Item;
use App\Entity\Price;
use App\Service\UniqueIdGenerator;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Faker;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;


abstract class RepositoryTestBase extends KernelTestCase
{
    const UNIQUEID_MAX     = 36;
    const FIRSTNAME_MAX    = 30;
    const LASTNAME_MAX     = 30;
    const EMAIL_MAX        = 60;
    const TITLE_MAX        = 255;
    const DESCRIPTION_MAX  = 999999;
    const STATUS_MAX       = 20;
    const AVAILABLE_STATUS = ["on", "off"];

    protected EntityManager|null $entityManager = null;
    protected LoggerInterface|null $logger = null;
    protected Faker\Generator|null $faker = null;
    protected UniqueIdGenerator|null $uuid = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->entityManager = $container
            ->get('doctrine')
            ->getManager();

        $this->uuid = $container->get(UniqueIdGenerator::class);
        $this->faker = Faker\Factory::create('fr_FR');
    }

    protected function assertIsStringWithMaxLength(int $length, mixed $value): void
    {
        $this->assertIsString($value);
        $this->assertLessThanOrEqual($length, strlen($value));
    }

    protected function assertUniqueId(mixed $value): void
    {
        $this->assertIsStringWithMaxLength(static::UNIQUEID_MAX, $value);
    }

    protected function assertTitle(mixed $value): void
    {
        $this->assertIsStringWithMaxLength(static::TITLE_MAX, $value);
    }

    protected function assertDescription(mixed $value): void
    {
        $this->assertIsString($value);
        $this->assertLessThanOrEqual(static::DESCRIPTION_MAX, strlen($value));
    }

    protected function assertFirstName(mixed $value): void
    {
        $this->assertIsString($value);
        $this->assertLessThanOrEqual(static::FIRSTNAME_MAX, strlen($value));
    }

    protected function assertLastName(mixed $value): void
    {
        $this->assertIsString($value);
        $this->assertLessThanOrEqual(static::LASTNAME_MAX, strlen($value));
    }

    protected function assertEmailAddress(mixed $value): void
    {
        $this->assertIsString($value);
        $this->assertLessThanOrEqual(static::EMAIL_MAX, strlen($value));
    }

    protected function assertAmount(mixed $value): void
    {
        $this->assertIsFloat($value);
        $this->assertGreaterThan(0, $value);
    }

    protected function assertStatus(mixed $value): void
    {
        $this->assertIsString($value);
        $this->assertLessThanOrEqual(static::STATUS_MAX, strlen($value));
        $this->assertContains($value, static::AVAILABLE_STATUS);
    }

    protected function assertNumberBetween(int $value, int $start, int $end): void
    {
        $this->assertIsNumeric($value);
        $this->assertGreaterThanOrEqual($start, $value);
        $this->assertLessThanOrEqual($end, $value);
    }

    protected function assertNumberBetweenExclusif(int $value, int $start, int $end): void
    {
        $this->assertIsNumeric($value);
        $this->assertGreaterThan($start, $value);
        $this->assertLessThan($end, $value);
    }

    protected function assertChoices(mixed $value, array $haystack): void
    {
        $this->assertIsString($value);
        $this->assertContains($value, $haystack);
    }

    protected function assertArrayOfString($value): void
    {
        $this->assertIsArray($value);
        $this->assertGreaterThan(0, count($value));
        $this->assertContainsOnly("string", $value);
    }

    protected function assertCollectionContainsInstancesOf($value, string $subClass): void
    {
        $this->assertInstanceOf(Collection::class, $value);
        $this->assertGreaterThan(0, count($value));
        $this->assertContainsOnlyInstancesOf($subClass, $value);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
