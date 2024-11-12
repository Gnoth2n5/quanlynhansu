<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Migrate extends Command
{
    protected function configure()
    {
        $this
            ->setName('migrate')
            ->setDescription('Run the migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Require the database configuration and initiate Capsule
        $capsule = require_once __DIR__ . '/../../../config/database.php';
        $databaseName = $capsule->getConnection()->getDatabaseName();

        // Check if the database exists
        if (!$this->databaseExists($capsule, $databaseName)) {
            $output->writeln("<error>Database '$databaseName' does not exist.</error>");

            // Ask the user if they want to create the database
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion("Would you like to create the database '$databaseName'? (yes/no) ", false);

            if (!$helper->ask($input, $output, $question)) {
                $output->writeln("<info>Migration aborted.</info>");
                return Command::SUCCESS;
            }

            // Create the database
            $this->createDatabase($capsule, $databaseName);
            $output->writeln("<info>Database '$databaseName' created successfully.</info>");
        } else {
            $output->writeln("<info>Database '$databaseName' already exists.</info>");
        }

        // Run migrations
        $migrationFiles = glob(__DIR__ . '/../../../database/migrations/*.php');

        foreach ($migrationFiles as $file) {
            $migration = require_once $file;

            // Check if the migration has an `up` method
            if (is_callable([$migration, 'up'])) {
                $tableName = str_replace(['create_', '_table.php'], '', basename($file));

                // Check if the table already exists
                if (!Capsule::schema()->hasTable($tableName)) {
                    // Run the migration
                    $migration->up();
                    $output->writeln("<info>Migration for table '$tableName' ran successfully.</info>");
                } else {
                    $output->writeln("<info>Table '$tableName' already exists. Skipping.</info>");
                }
            }
        }

        return Command::SUCCESS;
    }

    private function databaseExists($capsule, $databaseName)
    {
        try {
            // Connect to the server without specifying the database name
            $pdo = $capsule->getConnection()->getPdo();
            $query = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
            $query->execute([$databaseName]);
            return (bool) $query->fetchColumn();
        } catch (\Exception $e) {
            return false;
        }
    }

    private function createDatabase($capsule, $databaseName)
    {
        // Connect to the server without specifying the database name
        $config = $capsule->getConnection()->getConfig();
        $pdo = new \PDO("mysql:host={$config['host']};charset={$config['charset']}", $config['username'], $config['password']);

        // Create the database
        $pdo->exec("CREATE DATABASE `$databaseName`");
    }
}
