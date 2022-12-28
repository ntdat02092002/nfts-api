<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        $this->call([
            CryptoSeeder::class,
        ]);

//         \App\Models\User::factory()->create([
//             'name' => 'Admin',
//             'email' => 'admin@zeno.com',
//             'type' => 1
//         ]);

//         \App\Models\AccountBlance::create([
//             'user_id' => 1,
//             'crypto_id' => 1,
//             'balance' => 100
//         ]);

        // $this->call([
        //     PostTableSeeder::class,
        // ]);

        // $this->call([
        //     TopicSeeder::class,
        // ]);
        
    }
}
