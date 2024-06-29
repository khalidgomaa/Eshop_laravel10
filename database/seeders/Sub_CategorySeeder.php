<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sub_Category;

class Sub_CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sub_Category::factory()->count(30)->create();
    }
}
