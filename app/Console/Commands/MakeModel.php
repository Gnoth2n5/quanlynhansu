<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Facades\File;

class MakeModel extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:model')
            ->setDescription('Create a new Eloquent model')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the model');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = __DIR__ . '/../../Models/' . $name . '.php';

        if (file_exists($path)) {
            $output->writeln("<error>Model {$name} already exists!</error>");
            return Command::FAILURE;
        }

        $stub = $this->getStub();
        $stub = str_replace('{{modelName}}', $name, $stub);

        file_put_contents($path, $stub);

        $output->writeln("<info>Model {$name} created successfully.</info>");
        return Command::SUCCESS;
    }

    protected function getStub()
    {
        return <<<EOT
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {{modelName}} extends Model
{
    //
}
EOT;
    }
}