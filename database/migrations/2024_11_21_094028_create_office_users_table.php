<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('office_users')){
            Capsule::schema()->create('office_users', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('office_id');
                $table->unsignedBigInteger('user_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('office_id')
                ->references('id')
                ->on('offices')  
                ->onDelete('cascade');
                $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('office_users');
    }
};
        