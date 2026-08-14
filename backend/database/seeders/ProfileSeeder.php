<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'description' => 'Acesso administrativo',
        ]);

        Profile::create([
            'name' => 'Gerente',
            'slug' => 'manager',
            'description' => 'Acesso de gerenciamento',
        ]);

        Profile::create([
            'name' => 'Usuário',
            'slug' => 'user',
            'description' => 'Acesso padrão',
        ]);
    }
}
