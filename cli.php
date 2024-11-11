<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;

// Create a new application
$app = new Application();

// Register commands
$app->add(new App\Console\Commands\MakeModel());

// Run the application
$app->run();