<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Page;

class PageUITest extends TestCase
{
    
    use DatabaseMigrations;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $page = factory(Page::class)->create([
            'slug' => 'index',
        ]);        
        
         $this->visit('/')
             ->see($page->title)
             ->dontSee('Laravel 5');
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSpecificPage()
    {
        $page = factory(Page::class)->create();
        
         $this->visit('/' . $page->slug)
             ->see($page->title)
             ->dontSee('Laravel 5');        
    }   
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test404()
    {        
       
        $response = $this->call('GET', '/no-page');

        $this->assertEquals(404, $response->status());        
        
    }    
}
