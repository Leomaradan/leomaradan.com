<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\Page;

class SlugTemplateModelTest extends TestCase {

    use DatabaseMigrations;
    
    /**
     * Test the scope.
     *
     * @return void
     */
    public function testScope() {
        
        $page = factory(Page::class)->create();
        $slug = $page->slug;
          
        $page1 = Page::findBySlug($slug)->first();
        $page2 = Page::findBySlug('not a slug')->first();  
     
        $this->assertEquals($page->content, $page1->content);
        $this->assertNull($page2);
        
        $id = $page1->id;
        
        $page3 = Page::findById($id)->first();
        $page4 = Page::findById(-1)->first();
        
        $this->assertEquals($page->content, $page3->content);
        $this->assertNull($page4);
        
    }

    /**
     * Test the slug attribute.
     * 
     * @return void
     */
    public function testSlugAttribute() {

        $page = factory(Page::class)->make();
        
        $page->slug = "My New Slug";
        
        $this->assertEquals('my-new-slug', $page->slug);
        
        $page->slug = "my-new-slug-2";
        
        $this->assertEquals('my-new-slug-2', $page->slug);      
        
        $page->title = "Test Slug";
        $page->slug = "";
        
        $this->assertEquals('test-slug', $page->slug);            
        
        $page->id = 1;
        $page->title = null;
        $page->slug = "";
        
        $this->assertEquals('i1', $page->slug);              
    }
    
    /**
     * Test the generated URL
     * 
     * @return void
     */
    public function testRouteKey() {
        $page = factory(Page::class)->create();
        
        $this->assertEquals(url('/') . '/' . $page->slug, route('pages', $page));
    }

}
