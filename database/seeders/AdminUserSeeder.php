<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! env('ADMIN_EMAIL') || ! env('ADMIN_PASSWORD')) {
            $this->command?->warn('ADMIN_EMAIL / ADMIN_PASSWORD belum diisi di .env, akun admin dilewati.');
        } else {
            $admin = User::updateOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                [
                    'name' => env('ADMIN_NAME', 'Admin RouteMate'),
                    'password' => Hash::make(env('ADMIN_PASSWORD')),
                ]
            );
            $admin->role = 'admin';
            $admin->save();
        }

        if (! env('DEMO_USER_EMAIL') || ! env('DEMO_USER_PASSWORD')) {
            $this->command?->warn('DEMO_USER_EMAIL / DEMO_USER_PASSWORD belum diisi di .env, user demo dilewati.');
        } else {
            $demo = User::updateOrCreate(
                ['email' => env('DEMO_USER_EMAIL')],
                [
                    'name' => env('DEMO_USER_NAME', 'User Demo'),
                    'password' => Hash::make(env('DEMO_USER_PASSWORD')),
                ]
            );
            $demo->role = 'user';
            $demo->save();
        }
    }
}
