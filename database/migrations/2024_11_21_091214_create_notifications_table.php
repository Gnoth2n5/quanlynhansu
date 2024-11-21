<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('notifications')){
            Capsule::schema()->create('notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->text('title');
                $table->text('message');
                $table->unsignedInteger('office_id');
                $table->timestamps();

          $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
                
          $table->foreign('office_id')
                ->references('id')
                ->on('offices')  
                ->onDelete('cascade');
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('notifications');
    }
};
        