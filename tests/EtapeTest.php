<?php

namespace App\Tests;

use App\Entity\Etape;
use App\Entity\Ville;
use App\Entity\Voyage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EtapeTest extends KernelTestCase
{
    /**
     * @dataProvider entityProvider
     * @param Etape $etape
     * @param int $errorCountExpected Le nombre d'erreurs attendues
     */
    public function testAssertions(Etape $etape, int $errorCountExpected): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $validator = $container->get(ValidatorInterface::class);
        $errors = $validator->validate($etape);

        $this->assertCount($errorCountExpected, $errors);
    }

    public function entityProvider(): \Generator
    {
        yield [new Etape(), 5];

        $ville1 = (new Ville())->setName('ville1');
        $ville2 = (new Ville())->setName('ville2');

        // villes identiques
        yield [
            (new Etape())
                ->setDeparture($ville1)
                ->setArrival($ville1),
            4
        ];

        // villes différentes
        yield [
            (new Etape())
                ->setDeparture($ville1)
                ->setArrival($ville2),
            3
        ];
    }
}
