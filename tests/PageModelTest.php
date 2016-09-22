<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Page;

class PageModelTest extends TestCase
{
    
    use DatabaseMigrations;    
    
    public function setUp() {
        parent::setUp();
        
        factory(Page::class, 5)->create(); // initial
    }
    
    /**
     * test the setup function
     *
     * @return void
     */    
    public function testSetup() 
    {
        $this->assertEquals(5, count(Page::all()));
    }
    
    /**
     * test creating a page.
     *
     * @return void
     */
    public function testCreate()
    {
        
        $data = factory(Page::class)->make();
        
        $newPage = new Page;
        
        $newPage->title = $data->title;
        $newPage->slug = $data->slug;
        $newPage->content = $data->content;
        
        $newPage->save();
        
        $this->assertEquals(6, count(Page::all()));
        
        $checkPage = Page::findBySlug($data->slug)->first();
        
        $this->assertEquals($data->title, $checkPage->title);
        $this->assertEquals($data->slug, $checkPage->slug);
        $this->assertEquals($data->content, $checkPage->content);
        
    }
    
    /**
     * test updating fields.
     *
     * @return void
     */
    public function testUpdate()
    {
        $page = Page::first();
        
        $defaultTitle = $page->title;
        $defaultSlug = $page->slug;
        $defaultContent = $page->content;
        $id = $page->id;
        
        /* check initial */
        $checkPage = Page::findById($id)->first();
        
        $this->assertEquals($defaultTitle, $checkPage->title);
        $this->assertEquals($defaultSlug, $checkPage->slug);
        $this->assertEquals($defaultContent, $checkPage->content);        
        
        $page->title = "New Title";
        $page->save();
        
        $checkPage = Page::findById($id)->first();
        
        $this->assertEquals("New Title", $checkPage->title);
        $this->assertEquals($defaultSlug, $checkPage->slug);
        $this->assertEquals($defaultContent, $checkPage->content);
        
        $page->slug = "new-slug";
        $page->save();
        
        $checkPage = Page::findById($id)->first();
        
        $this->assertEquals("New Title", $checkPage->title);
        $this->assertEquals("new-slug", $checkPage->slug);
        $this->assertEquals($defaultContent, $checkPage->content);      
        
        $page->content = "new content";
        $page->save();
        
        $checkPage = Page::findById($id)->first();
        
        $this->assertEquals("New Title", $checkPage->title);
        $this->assertEquals("new-slug", $checkPage->slug);
        $this->assertEquals("new content", $checkPage->content);            
    } 
    
    /**
     * test deleting a page.
     *
     * @return void
     */
    public function testDelete()
    {
        $page = Page::first();
        
        $page->delete();
        
        $this->assertEquals(4, count(Page::all()));
    }  
    
    /**
     * Atest fillable fields with incomplete values.
     *
     * @return void
     */
    public function testFillableIncomplete()
    {
        $this->expectException(Illuminate\Database\QueryException::class);
        Page::create(['id' => 1]);
    }   
    
    /**
     * test fillable fields.
     *
     * @return void
     */
    public function testFillable()
    {
        $page = Page::create(['id' => 999, 'title' => 'title', 'slug' => 'slug', 'content' => 'content']);
        $this->assertEquals(6, count(Page::all()));
        
        $this->assertEquals(6, $page->id);
        $this->assertEquals("title", $page->title);
        $this->assertEquals("slug", $page->slug);
        $this->assertEquals("content", $page->content);          
    }       
    
    /**
     * test the hidden fields.
     *
     * @return void
     */
    public function testHiddenFields()
    {
        $page = Page::first();
        
        $checkHidden = $page->toArray();
        
        $comparisonArray = [
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content
        ];
        
        $this->assertEquals($comparisonArray, $checkHidden);
    }       
}
