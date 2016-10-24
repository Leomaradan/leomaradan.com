<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\EditRssFluxRequest;
use App\Models\Rss\Article;
use App\Models\Rss\Flux;

use Artisan;

class AdminRssFluxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fluxes = Flux::paginate(10);
        return view('backend.rss.index', compact('fluxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        $flux = new Flux();
        $form = ['url' => route('admin.flux.store')];
        return view('backend.rss.create', compact('flux', 'form'));
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditRssFluxRequest $request)
    {
        
        //dd($request);
        $flux = Flux::create($request->all());
        
        Artisan::queue('sync:rss');        

        return redirect(route('admin.rss.index', $flux));
    }


    
    private function getCategories() {
        $fluxes = Flux::orderBy('title')->get();//all()
        $categories = [];
        foreach($fluxes as $flux) {
            $cat = $flux->category;
            if(!isset($categories[$cat])) {
                $categories[$cat] = [];
            }
            
            $categories[$cat][] = ['id' => $flux->id, 'title' => $flux->title, 'link' => route('admin.rss.read.flux',$flux)];
        }
        
        return $categories;
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function show()
    {

        $categories = $this->getCategories();
        $articles = Article::orderBy('published_at', 'desc')->paginate(10);
        $highlight = null;
        
        return view('backend.rss.show', compact('categories','articles','highlight'));
    }
    
    public function showCategory($id)
    {
        $category_ids = Flux::where('category', Flux::where('id', $id)->firstOrFail()->category)->pluck('id');
        $categories = $this->getCategories();
        $articles = Article::whereIn('flux_id', $category_ids)->orderBy('published_at', 'desc')->paginate(10);
        $highlight = route('admin.rss.read.category',$id);
        
        return view('backend.rss.show', compact('categories','articles','highlight'));
    }    
    
    public function showFlux($id)
    {
        
        $categories = $this->getCategories();
        $articles = Article::where('flux_id', $id)->orderBy('published_at', 'desc')->paginate(10);
        $highlight = route('admin.rss.read.flux',$id);
        
        return view('backend.rss.show', compact('categories','articles','highlight'));
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        $flux = Flux::where('id', $id)->first();
        $form = ['method' => 'put', 'url' => route('admin.rss.update', $flux)];
        return view('backend.rss.edit', compact('flux', 'form'));
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRssFluxRequest $request, $id)
    {
        $flux = Flux::where('id', $id)->first();

        $flux->update($request->all());

        return response()->json([
            'id' => $flux->id, 
            'title' => $flux->title, 
            'url' => $flux->url,
            'category' => $flux->category
        ])->setCallback($request->input('callback'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, EditRssFluxRequest $request)
    {
        $flux = Flux::where('id', $id)->first();

        $flux->articles()->delete();        
        
        $flux->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
}
