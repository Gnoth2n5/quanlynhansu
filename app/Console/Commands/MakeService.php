<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeService extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:service')
            ->setDescription('Create a new service')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the service');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $path = __DIR__ . '/../../Services/' . $name . '.php';

        if (file_exists($path)) {
            $output->writeln("<error>Service {$name} already exists!</error>");
            return Command::FAILURE;
        }

        $stub = $this->getStub();
        $stub = str_replace('{{serviceName}}', $name, $stub);

        file_put_contents($path, $stub);

        $output->writeln("<info>Service {$name} created successfully.</info>");
        return Command::SUCCESS;
    }

    protected function getStub()
    {
        return <<<EOT
<?php

namespace App\Services;

class {{serviceName}} extends Service
{
    //
}
EOT;
    }
}