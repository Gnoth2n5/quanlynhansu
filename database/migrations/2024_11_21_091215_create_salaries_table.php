<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('salaries')){
            Capsule::schema()->create('salaries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('base_salary', 10, 2);
                $table->decimal('total_salary', 10, 2);
                $table->decimal('total_deductions', 10, 2);
                $table->decimal('net_salary', 10, 2);
                $table->date('pay_date');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                
                $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
                });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('salaries');
    }
};
        