<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (empty(config('postcode.postcode_table_name'))) {
            throw new \Exception('Error: config/postcode.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if (!Schema::connection(config('postcode.database_connection_name'))->hasTable(config('postcode.postcode_table_name'))) {
            Schema::connection(config('postcode.database_connection_name'))->create(config('postcode.postcode_table_name'), function (Blueprint $table) {
                $table->increments('id');
                $table->string('postcode', 10);
                $table->unsignedSmallInteger('pnum')->nullable();
                $table->string('pchar', 10)->nullable();
                $table->unsignedSmallInteger('minnumber');
                $table->unsignedSmallInteger('maxnumber');
                $table->string('numbertype', 10);
                $table->string('street', 100);
                $table->string('city', 100);
                $table->string('municipality', 100)->nullable();
                $table->unsignedSmallInteger('municipality_id')->nullable();
                $table->string('province', 30);
                $table->string('province_code', 2)->nullable();
                $table->double('lat')->nullable();
                $table->double('lon')->nullable();
                $table->double('rd_x')->nullable();
                $table->double('rd_y')->nullable();
                $table->index(['postcode', 'minnumber', 'maxnumber', 'numbertype'], 'pcd_ind_pcd_min_max');
            });
        }
        if (config('postcode.postcode_table_not_found')) {
            if (!Schema::connection(config('postcode.database_connection_name'))->hasTable(config('postcode.postcode_table_not_found'))) {
                Schema::connection(config('postcode.database_connection_name'))->create(config('postcode.postcode_table_not_found'), function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('postcode', 10);
                    $table->string('number', 20)->nullable();
                    $table->timestamps();
                });
            }
        }
    }


    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::connection(config('postcode.database_connection_name'))->dropIfExists(config('postcode.postcode_table_name'));
        Schema::connection(config('postcode.database_connection_name'))->dropIfExists(config('postcode.postcode_table_not_found'));
        Schema::enableForeignKeyConstraints();
    }
};