<?php

namespace mmerlijn\laravelPostcode\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::connection(config('postcode.database_connection'))
            ->table(config('postcode.postcode_table_name'))->count()) {
            DB::connection(config('postcode.database_connection'))
                ->table(config('postcode.postcode_table_name'))->insert([
                    [
                        'postcode' => '1187DJ',
                        'minnumber' => '1',
                        'maxnumber' => '50',
                        'numbertype' => 'mixed',
                        'street' => 'Duivenvoorde',
                        'city' => 'Amstelveen',
                        'province' => 'Noord-Holland',
                        'lat' => '52.2789282653576',
                        'lon' => '4.8154790839451',
                    ],
                    [
                        'postcode' => '1187KA',
                        'minnumber' => '2',
                        'maxnumber' => '46',
                        'numbertype' => 'even',
                        'street' => 'Gaasterland',
                        'city' => 'Amstelveen',
                        'province' => 'Noord-Holland',
                        'lat' => '52.2832044474887',
                        'lon' => '4.8226758530788',
                    ],
                    [
                        'postcode' => '1187LS',
                        'minnumber' => '1',
                        'maxnumber' => '7',
                        'numbertype' => 'odd',
                        'street' => 'Westwijkplein',
                        'city' => 'Amstelveen',
                        'province' => 'Noord-Holland',
                        'lat' => '52.281458330925',
                        'lon' => '4.8261185828603',
                    ],
                    [
                        'postcode' => '6713NS',
                        'minnumber' => '1',
                        'maxnumber' => '5',
                        'numbertype' => 'odd',
                        'street' => 'Willem de Zwijgerlaan',
                        'city' => 'Ede',
                        'province' => 'Gelderland',
                        'lat' => '52.0334244919197',
                        'lon' => '5.6610250300889',
                    ],
                    [
                        'postcode' => '6713PC',
                        'minnumber' => '67',
                        'maxnumber' => '91',
                        'numbertype' => 'odd',
                        'street' => 'Juliana van Stolberglaan',
                        'city' => 'Ede',
                        'province' => 'Gelderland',
                        'lat' => '52.03251630291',
                        'lon' => '5.6624748754496',
                    ],
                ]);
        }
    }
}
