<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Adventure',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac posuere tortor, ac pretium tellus. Fusce vestibulum rutrum sapien non consectetur. Proin tempus tincidunt tincidunt. Vivamus vel dignissim ipsum. Suspendisse aliquet sagittis vehicula. Phasellus consectetur auctor metus et luctus. Vestibulum porta sodales mi vel elementum. Ut at eros non sem pulvinar tempus. '
        ]);
        DB::table('categories')->insert([
            'name' => 'Fiction',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac posuere tortor, ac pretium tellus. Fusce vestibulum rutrum sapien non consectetur. Proin tempus tincidunt tincidunt. Vivamus vel dignissim ipsum. Suspendisse aliquet sagittis vehicula. Phasellus consectetur auctor metus et luctus. Vestibulum porta sodales mi vel elementum. Ut at eros non sem pulvinar tempus. '
        ]);
    }
}
