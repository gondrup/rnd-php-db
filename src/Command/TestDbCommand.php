<?php

namespace App\Command;

use App\Patabase\Patabase;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-db',
    description: 'Test Patabase',
)]
class TestDbCommand extends Command
{
    public function __construct(
        private Patabase $patabase,
    )
    {
        parent::__construct();
    }

    private function initiateTestDb(): void
    {
        if (!$this->patabase->storeExists('cars')) {
            $this->patabase->createStore('cars', ['id', 'make', 'model', 'reg']);
        }

        $this->patabase->add('cars', ['id' => 1, 'make' => 'Audi', 'model' => 'A1', 'reg' => 'KV61VML']);
        $this->patabase->add('cars', ['id' => 2, 'make' => 'BMW', 'model' => 'X5', 'reg' => 'DV51XKK']);
        $this->patabase->add('cars', ['id' => 3, 'make' => 'Audi', 'model' => 'A3', 'reg' => 'ZY98XWV']);
        $this->patabase->add('cars', ['id' => 4, 'make' => 'Audi', 'model' => 'Q5', 'reg' => 'AB12CDE']);
    }

    /**
     * @param Entry[] $results
     * @param OutputInterface $output
     * @return void
     */
    private function renderResults(array $results, OutputInterface $output): void
    {
        $rows = [];
        foreach ($results as $entry) {
            $row = [];
            foreach ($entry as $fieldValue) {
                $row[] = $fieldValue->getValue();
            }
            $rows[] = $row;
        }

        $table = new Table($output);
        $table
            ->setHeaders(['id', 'make', 'model', 'reg'])
            ->setRows($rows);
        $table->render();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        #$this->initiateTestDb();

        $results = $this->patabase->select('cars', ['make' => 'Audi'], ['id', 'asc']);
        $this->renderResults($results, $output);

        $results = $this->patabase->select('cars', ['make' => 'Audi'], ['id', 'desc']);
        $this->renderResults($results, $output);

        $results = $this->patabase->select('cars', ['make' => 'BMW'], ['id', 'asc']);
        $this->renderResults($results, $output);

        return Command::SUCCESS;
    }
}
