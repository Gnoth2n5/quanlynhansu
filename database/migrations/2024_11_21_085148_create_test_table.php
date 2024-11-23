<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('test')){
            Capsule::schema()->create('test', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('test');
    }
};
        