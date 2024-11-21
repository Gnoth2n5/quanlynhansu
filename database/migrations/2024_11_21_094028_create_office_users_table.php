<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('office_users')){
            Capsule::schema()->create('office_users', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('office_id');
                $table->unsignedInteger('user_id');

          $table->foreign('office_id')
                ->references('id')
                ->on('offices')  
                ->onDelete('cascade');
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
        Capsule::schema()->dropIfExists('office_users');
    }
};
        