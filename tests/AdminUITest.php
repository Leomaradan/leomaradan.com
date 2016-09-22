<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUITest extends TestCase
{
    
    use DatabaseMigrations;    
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRedirectGuest()
    {
        $response = $this->call('GET', '/admin');

        $this->assertEquals(302, $response->status()); 
    }
    
    public function testAdmin() {

        $this->loginAdmin();
        
        $this->visit('/admin')
             ->see('backend');
    }
    
    public function loginAdmin() {
        $this->visit('/login')
            ->type('admin@localhost', 'email')
            ->type('admin', 'password')
            ->press('Login');
    }
}
