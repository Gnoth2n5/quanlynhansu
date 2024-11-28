<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        if(!Capsule::schema()->hasTable('notify_office')){
            Capsule::schema()->create('notify_office', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('office_id');
                $table->unsignedBigInteger('notify_id');

                $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
                $table->foreign('notify_id')->references('id')->on('notifications')->onDelete('cascade');

                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }
    }
    
    public function down()
    {
        Capsule::schema()->dropIfExists('notify_office');
    }
};
        