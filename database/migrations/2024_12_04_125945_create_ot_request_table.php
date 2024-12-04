<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('ot_request')){
            Capsule::schema()->create('ot_request', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('shift_id');

                $table->decimal('requested_hours', 5, 2);
                $table->decimal('approved_hours', 5, 2)->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('ot_request');
    }
};
        