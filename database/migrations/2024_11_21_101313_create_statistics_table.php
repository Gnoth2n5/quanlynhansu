<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('statistics')){
            Capsule::schema()->create('statistics', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedInteger('attendance_days');
                $table->unsignedInteger('late_days');
                $table->unsignedInteger('absent_days');
                $table->unsignedInteger('year');
                $table->unsignedInteger('month');
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
        Capsule::schema()->dropIfExists('statistics');
    }
};
        