<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('users')){
            Capsule::schema()->create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username');
                $table->string('password');
                $table->string('full_name');
                $table->string('address')->nullable();
                $table->date('birthday');
                $table->enum('gender', ['male', 'female', 'other']);
                $table->string('avatar')->nullable();
                $table->string('email');
                $table->string('phone')->nullable();
                $table->unsignedBigInteger('role_id');
                $table->enum('status',['active', 'inactive']);
                $table->string('UID');                
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                

                $table->foreign('role_id')
                      ->references('id')
                      ->on('roles')  
                      ->onDelete('restrict');
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('users');
    }
};
        