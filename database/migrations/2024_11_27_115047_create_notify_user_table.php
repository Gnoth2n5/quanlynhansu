<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('notify_user')){
            Capsule::schema()->create('notify_user', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('notify_id');


                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->foreign('notify_id')->references('id')->on('notifications')->onDelete('cascade');


                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('notify_user');
    }
};
        