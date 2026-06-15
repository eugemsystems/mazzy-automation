<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The South African provinces with their ISO 3166-2:ZA codes.
     *
     * @var array<string, string>
     */
    protected $provinces = [
        'EC' => 'Eastern Cape',
        'FS' => 'Free State',
        'GP' => 'Gauteng',
        'KN' => 'KwaZulu-Natal',
        'LP' => 'Limpopo',
        'MP' => 'Mpumalanga',
        'NC' => 'Northern Cape',
        'NW' => 'North West',
        'WC' => 'Western Cape',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $country = DB::table('countries')->where('code', 'ZA')->first();

        if (! $country) {
            return;
        }

        foreach ($this->provinces as $code => $name) {
            $exists = DB::table('country_states')
                ->where('country_code', 'ZA')
                ->where('code', $code)
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('country_states')->insert([
                'country_id' => $country->id,
                'country_code' => 'ZA',
                'code' => $code,
                'default_name' => $name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('country_states')
            ->where('country_code', 'ZA')
            ->whereIn('code', array_keys($this->provinces))
            ->delete();
    }
};
