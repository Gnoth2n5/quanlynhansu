<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('offices')){
            Capsule::schema()->create('offices', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('location');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE  CURRENT_TIMESTAMP'));
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('offices');
    }
};
        