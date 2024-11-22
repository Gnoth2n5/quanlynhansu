<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('user_shift')){
            Capsule::schema()->create('user_shift', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('shift_id');
                
          $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');

          $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')  
                ->onDelete('cascade');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('user_shift');
    }
};
        