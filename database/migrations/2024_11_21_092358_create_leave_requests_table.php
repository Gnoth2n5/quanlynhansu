<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('leave_requests')){
            Capsule::schema()->create('leave_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->text('reason');
                $table->unsignedBigInteger('approved_by');
                $table->enum('status',['pending', 'approved', 'rejected']);
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                

                $table->foreign('user_id')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');

                $table->foreign('approved_by')
                ->references('id')
                ->on('users')  
                ->onDelete('cascade');
                });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('leave_requests');
    }
};
        