<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('salary_adjustments')){
            Capsule::schema()->create('salary_adjustments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('salary_id');
                $table->unsignedBigInteger('user_id');
                $table->enum('type',['bonus','deduction','raise']);
                $table->decimal('amount', 10, 2);
                $table->string('description');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                
                $table->foreign('salary_id')
                ->references('id')
                ->on('salaries')  
                ->onDelete('cascade');
                
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
        