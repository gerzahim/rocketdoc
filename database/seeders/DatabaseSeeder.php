<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Gerza',
                'email' => 'admin',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);
        //$this->call(UserSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ReleaseSeeder::class);
        $this->call(IssueSeeder::class);


    }
}
