<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('admin'),
            'status' => 'admin'
        ]);
        
        DB::table('menus')->insert([
            ['id' => 1, 'zone' => 'admin', 'parent' => null, 'type' => null, 'title' => 'Pages', 'link' => '', 'order' => 1],
            ['id' => 2, 'zone' => 'admin', 'parent' => null, 'type' => null, 'title' => 'Blog', 'link' => '', 'order' => 2],
            ['id' => 3, 'zone' => 'admin', 'parent' => null, 'type' => null, 'title' => 'Comptes', 'link' => '', 'order' => 3],
            
            ['id' => 4, 'zone' => 'admin', 'parent' => 1, 'type' => 'internalLink', 'title' => 'Ajouter une page', 'link' => 'admin.pages.create', 'order' => 10],
            ['id' => 5, 'zone' => 'admin', 'parent' => 1, 'type' => 'internalLink', 'title' => 'Liste des pages', 'link' => 'admin.pages.index', 'order' => 11],
            
            ['id' => 6, 'zone' => 'admin', 'parent' => 2, 'type' => 'internalLink', 'title' => 'Ajouter un article', 'link' => 'admin.posts.create', 'order' => 20],
            ['id' => 7, 'zone' => 'admin', 'parent' => 2, 'type' => 'internalLink', 'title' => 'Liste des articles', 'link' => 'admin.posts.index', 'order' => 21],
            ['id' => 8, 'zone' => 'admin', 'parent' => 2, 'type' => 'separator', 'title' => '', 'link' => '', 'order' => 22],
            ['id' => 9, 'zone' => 'admin', 'parent' => 2, 'type' => 'internalLink', 'title' => 'Liste des catégories', 'link' => 'admin.posts.categories.index', 'order' => 23],
            ['id' => 10, 'zone' => 'admin', 'parent' => 2, 'type' => 'separator', 'title' => '', 'link' => '', 'order' => 24],
            ['id' => 11, 'zone' => 'admin', 'parent' => 2, 'type' => 'internalLink', 'title' => 'Liste des tags', 'link' => 'admin.posts.tags.index', 'order' => 25],
            
            ['id' => 12, 'zone' => 'admin', 'parent' => 3, 'type' => 'internalLink', 'title' => 'Ajouter un compte', 'link' => 'admin.users.create', 'order' => 30],
            ['id' => 13, 'zone' => 'admin', 'parent' => 3, 'type' => 'internalLink', 'title' => 'Liste des comptes', 'link' => 'admin.users.index', 'order' => 31],            
            
            
        ]);
        
        DB::table('menus')->insert([
            ['zone' => 'main', 'parent' => null, 'type' => 'internalLink', 'title' => 'Home', 'link' => 'index', 'order' => 1],
            ['zone' => 'main', 'parent' => null, 'type' => 'internalLink', 'title' => 'Blog', 'link' => 'blog.index', 'order' => 2],
            ['zone' => 'main', 'parent' => null, 'type' => 'internalLink', 'title' => 'Liens', 'link' => 'index', 'order' => 3],
            ['zone' => 'main', 'parent' => null, 'type' => 'externalLink', 'title' => 'CV', 'link' => 'cv', 'order' => 4],
        ]);        
    }
}
