<?php

use Illuminate\Database\Seeder;
use App\Rtindex;

class RtindicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rtindices')->delete();

    	Rtindex::create([
            'start_id' => 22,
            'end_id' => 22,
    	]);
    }
}
