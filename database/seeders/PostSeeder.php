<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@devlog.test'],
            [
                'name' => 'DevLog Admin',
                'password' => 'password',
            ],
        );

        $posts = [
            [
                'title' => 'Getting Started with Laravel 13',
                'content' => "Laravel 13 keeps the framework's batteries-included philosophy while trimming boilerplate. A fresh install boots in seconds, and the new structure puts routing, middleware, and exceptions in one readable place.\n\nIn this post I walk through a minimal API-only setup: routes, a couple of FormRequest classes, and Eloquent models wired to PostgreSQL.",
            ],
            [
                'title' => 'Vue 3 Composition API Essentials',
                'content' => "The Composition API changed how I organise Vue components. Instead of scattering logic across data, methods, and computed, related concerns now live together in composables.\n\nI refactored the DevLog frontend into usePosts, useComments, and useAuth composables. Each one owns a slice of state and talks to the API through a single Axios instance.",
            ],
            [
                'title' => 'Designing a REST API with Laravel Sanctum',
                'content' => "Token-based auth is a natural fit for a decoupled SPA. Laravel Sanctum issues personal access tokens that the client stores and sends back as a Bearer header.\n\nHere I cover the login flow, protecting write routes behind the auth:sanctum middleware, and how a 401 interceptor cleans up the token on the client side.",
            ],
            [
                'title' => 'Running PostgreSQL in Docker',
                'content' => "A local database should never be a mystery. A single docker run command gives me an isolated PostgreSQL 15 instance with a known user, password, and database.\n\nThe DevLog backend connects over 127.0.0.1:5432, and the whole setup lives in a named container called devlog-db — easy to start, stop, and reset.",
            ],
            [
                'title' => "Tailwind CSS 4: What's New",
                'content' => "Tailwind CSS 4 ships a CSS-first configuration model and a faster engine. No more tailwind.config.js for most projects; the theme now lives directly in CSS.\n\nDevLog leans on the new @theme directive and the Vite plugin, which keeps the build pipeline fast and the utility classes on demand.",
            ],
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['title' => $post['title']],
                [
                    'user_id' => $admin->id,
                    'content' => $post['content'],
                ],
            );
        }
    }
}
