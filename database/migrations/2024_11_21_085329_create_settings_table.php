<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('settings')){
            Capsule::schema()->create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('setting_key');
                $table->text('setting_value');
                $table->text('description');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('settings');
    }
};
        