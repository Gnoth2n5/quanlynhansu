<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class MakeTable extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:table')
            ->setDescription('Create a new table')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the table');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        
        // set timezone
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $path = __DIR__ . '/../../../database/migrations/' . date('Y_m_d_His') . '_create_' . $name . '_table.php';

        // kiểm tra file đã tồn tại hay chưa
        if (file_exists($path)) {
            $output->writeln('<error>Table ' . $name . ' already exists!</error>');
            return Command::FAILURE;
        }

        // lấy nội dung của file stub
        $stub = $this->getStub();
        $stub = str_replace('{{tableName}}', $name, $stub);

        // tạo file mới
        if (!file_put_contents($path, $stub)) {
            $output->writeln('<error>Failed to create table ' . $name . '!</error>');
            return Command::FAILURE;
        }

        // thông báo tạo file thành công
        $output->writeln('<info>Table ' . $name . ' created successfully.</info>');
        return Command::SUCCESS;
    }

    protected function getStub()
    {
        return <<<EOT
<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('{{tableName}}', function (\$table) {
    \$table->increments('id');
    \$table->timestamps();
});
        
EOT;
    }
}