<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class MakeSeed extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:seed')
            ->setDescription('Create a new seed')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the seed');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        $path = __DIR__ . '/../../../database/seeders/'.$name.'.php';

        // kiểm tra file đã tồn tại hay chưa
        if (file_exists($path)) {
            $output->writeln('<error>Seeder ' . $name . ' already exists!</error>');
            return Command::FAILURE;
        }

        // lấy nội dung của file stub
        $stub = $this->getStub();
        $stub = str_replace('{{seedName}}', $name, $stub);

        // tạo file mới
        if (!file_put_contents($path, $stub)) {
            $output->writeln('<error>Failed to create seed ' . $name . '!</error>');
            return Command::FAILURE;
        }

        // thông báo tạo file thành công
        $output->writeln('<info>Seeder ' . $name . ' created successfully.</info>');
        return Command::SUCCESS;
    }

    protected function getStub()
    {
        return <<<EOT
<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class {{seedName}}
{
    public function run()
    {
        // Thêm logic fake data vào đây
        Capsule::table('your_table_name')->insert([
            // Ví dụ:
            // 'column_name' => 'value',
        ]);
    }
}
        
EOT;
    }
}