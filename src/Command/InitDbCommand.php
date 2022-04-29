<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Etape;
use App\Entity\Ville;
use App\Entity\Voyage;
use App\Repository\VilleRepository;
use App\Repository\VoyageRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:init-db',
    description: 'Parse les fichiers json de demo et les persist en db',
)]
class InitDbCommand extends Command
{
    public function __construct
    (
        private string $projectDir,
        private VoyageRepository $voyageRepository,
        private VilleRepository $villeRepository,
        private ValidatorInterface $validator,
        string $name = null,
    )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // lecture des fichiers json
        $finder = new Finder();
        $finder->in("{$this->projectDir}/data")->files()->name('*.json');

        $voyageCount = 0;
        foreach($finder as $file) {
            /** @var SplFileInfo $file */
            $voyageNom = $file->getFilenameWithoutExtension();

            if ($this->voyageRepository->findOneBy(['name' => $voyageNom])) {
                $io->warning(sprintf("Le voyage '%s' existe deja", $voyageNom));
                continue;
            }

            $voyage = (new Voyage())->setName($voyageNom);

            // parsing des steps
            $steps = json_decode($file->getContents(), true);
            foreach ($steps as $step) {
                /**
                 * exemple structure
                 * {
                     "type": "plane",
                     "number": "SK455",
                     "departure": "Gerona Airport",
                     "arrival": "Stockholm",
                     "seat": "3A",
                     "gate": "45B",
                     "baggage_drop": "344"
                   }
                 */

                $etape = New Etape();

                if (!empty($step['type'])) {
                    $etape->setType($step['type']);
                }

                if (!empty($step['number'])) {
                    $etape->setNumber($step['number']);
                }

                if (!empty($step['departure'])) {
                    $etape->setDeparture($this->findOrPersistVille($step['departure']));
                }

                if (!empty($step['arrival'])) {
                    $etape->setArrival($this->findOrPersistVille($step['arrival']));
                }

                $etape
                    ->setSeat($step['seat']??null)
                    ->setGate($step['gate']??null)
                    ->setBaggageDrop($step['baggage_drop']??null)
                    ->setVoyage($voyage)
                ;

                // validation
                $errors = $this->validator->validate($etape);
                if (count($errors) > 0) {
                    $io->warning((string) $errors);
                    continue 2;
                }

                $voyage->addEtape($etape);
            }

            $this->voyageRepository->add($voyage);
            $voyageCount++;
        }

        $io->success(sprintf("%d voyage(s) persisted", $voyageCount));

        return Command::SUCCESS;
    }

    /**
     * Cherche une ville en db, la persiste si inexistante
     *
     * @param string $name
     * @return Ville
     */
    private function findOrPersistVille(string $name): Ville
    {
        if (!$ville = $this->villeRepository->findOneBy(['name' => $name])) {
            $ville = (new Ville())->setName($name);
            $this->villeRepository->add($ville);
        }

        return $ville;
    }
}
