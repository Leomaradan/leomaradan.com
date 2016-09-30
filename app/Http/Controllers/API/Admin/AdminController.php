<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;

use App\Models\Pages;
use App\Models\Menu;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return Menu::getMenu('admin');
    	//return response()->json(['name' => 'Admin', 'href' => '#']);
		/*return response()->json(json_decode('[            
	{"name": "Pages", "submenu": [
		{"name":"Ajouter une page","href":"'.route('admin.pages.create').'"},
		{"name":"Liste des pages","href":"'.route('admin.pages.index').'"}
	]},
	{"name": "Blog", "submenu": [
		{"name":"Ajouter un article","href":"'.route('admin.posts.create').'"},
		{"name":"Liste des articles","href":"'.route('admin.posts.index').'"},
		{"divider": "true"},
		{"name":"Liste des catégories","href":"'.route('admin.posts.categories.index').'"},
		{"divider": "true"},
		{"name":"Liste des tags","href":"'.route('admin.posts.tags.index').'"}
	]},
	{"name": "Comptes", "submenu": [
		{"name":"Ajouter un compte","href":"'.route('admin.users.create').'"},
		{"name":"Liste des comptes","href":"'.route('admin.users.index').'"}
	]}
]'));*/
    }

    public function pages() {
        $pages = Pages::all();
        return response()->json($pages->toJson());
    }
}
