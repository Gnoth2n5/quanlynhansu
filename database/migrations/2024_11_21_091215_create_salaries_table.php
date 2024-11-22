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
                $table->decimal('base_salary');
                $table->decimal('total_salary');
                $table->decimal('total_deductions');
                $table->decimal('net_salary');
                $table->date('pay_date');
                
          $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('salaries');
    }
};
        