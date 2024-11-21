<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('attendance')){
            Capsule::schema()->create('attendance', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->dateTime('check_in');
                $table->dateTime('check_out');
                $table->enum('check_in_status', ['on_time', 'late', 'absent']);
                $table->enum('check_out_status', ['on_time', 'early_exit']);

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
        Capsule::schema()->dropIfExists('attendance');
    }
};
        