<?php

namespace App\Tests;

use App\Entity\Etape;
use App\Entity\Ville;
use App\Entity\Voyage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VoyageTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @dataProvider entityProvider
     * @param Voyage $voyage
     * @param int $errorCountExpected Le nombre d'erreurs attendues
     */
    public function testAssertions(Voyage $voyage, int $errorCountExpected): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $validator = $container->get(ValidatorInterface::class);
        $errors = $validator->validate($voyage);

        $this->assertCount($errorCountExpected, $errors);
    }

    /**
     * Check de ne pas passer par les mêmes villes
     */
    public function testUniqueEntityAssertions()
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $voyage = $this->entityManager->getRepository(Voyage::class)->findOneBy([]);

        $etape = $voyage->getEtapes()->first();
        $voyage->getEtapes()->clear();

        $voyage
            ->addEtape($etape)
            ->addEtape($etape);

        $validator = $container->get(ValidatorInterface::class);
        $errors = $validator->validate($voyage);
        $this->assertCount(2, $errors);
    }

    public function entityProvider(): \Generator
    {
        yield [new Voyage(), 2];
        yield [(new Voyage())->setName('voyage test'), 1];
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
