<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('leave_requests')){
            Capsule::schema()->create('leave_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->text('reason');
                $table->unsignedInteger('approved_by');
                $table->enum('status',['pending', 'approved', 'rejected']);
                

             $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');

             $table->foreign('approved_by')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
                $table->timestamps();
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('leave_requests');
    }
};
        