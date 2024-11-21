<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('shifts')){
            Capsule::schema()->create('shifts', function (Blueprint $table) {
                $table->id();
                $table->string('shift_name');
                $table->time('start_time');
                $table->time('end_time');
                $table->tinyInteger('is_overtime');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('shifts');
    }
};
        