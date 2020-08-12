<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Cinema\Models\Movie;
use App\Cinema\Models\Turn;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User admin
        $useradmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin1234')
        ]);

        $movie = Movie::create([
            'name' => '300',
            'publication_date' => '2020-08-12',
            'path' => '/var/www/public/movies/1-bc9359fb2afeb93.jpeg'
        ]);

        $turn = Turn::create([
            'turn' => '13:40',
            'status' => 1
        ]);

        $movie->turns()->attach($turn);
    }
}
