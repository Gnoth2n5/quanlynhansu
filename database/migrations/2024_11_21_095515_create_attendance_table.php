<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('attendance')){
            Capsule::schema()->create('attendance', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->dateTime('check_in');
                $table->dateTime('check_out')->nullable();
                $table->enum('check_in_status', ['on_time', 'late', 'absent']);
                $table->enum('check_out_status', ['on_time', 'early_exit'])->nullable();
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
        Capsule::schema()->dropIfExists('attendance');
    }
};
        