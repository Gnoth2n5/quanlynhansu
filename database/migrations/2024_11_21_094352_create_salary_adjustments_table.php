<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('salary_adjustments')){
            Capsule::schema()->create('salary_adjustments', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('salary_id');
                $table->unsignedInteger('user_id');
                $table->enum('type',['bonus','deduction','raise']);
                $table->decimal('amount');
                $table->string('description');
                $table->date('adjustment_date');
                
          $table->foreign('salary_id')
                ->references('id')
                ->on('salaries')  
                ->onDelete('cascade');
                $table->timestamps();
                

          $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('salary_adjustments');
    }
};
        