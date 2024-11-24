<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunSeed extends Command
{
    protected function configure()
    {
        $this
            ->setName('db:seed')
            ->setDescription('Run seeders')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'The name of the seeder file (default: DatabaseSeeder)',
                'DatabaseSeeder' // Giá trị mặc định
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        require_once __DIR__ . '/../../../config/database.php';
        
        $name = $input->getArgument('name');
        $class = "\\Database\\Seeders\\{$name}";

        if (!class_exists($class)) {
            $output->writeln("<error>Seeder $name không tồn tại!</error>");
            return Command::FAILURE;
        }

        $seeder = new $class();
        $seeder->run();

        $output->writeln("<info>Seeder $name chạy thành công!</info>");
        return Command::SUCCESS;
    }
}