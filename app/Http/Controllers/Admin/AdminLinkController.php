<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request; 
use App\Http\Requests\EditLinkRequest;

use App\Http\Requests;

use App\Http\Controllers\Admin\Controller;

use App\Models\Link;
use App\Models\TwitterLink;

use \DB;
use Twitter;

class AdminLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Link::orderBy('created_at')->paginate(10);
        return view('backend.links.index', compact('links'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditLinkRequest $request)
    {
        $link = new Link();
        
        $link->title = $request->input('title');
        $link->url = $request->input('url');
        $link->description = $request->input('description');
        
        $link->permalink = DB::raw('NOW()');
        
        $link->save();
        
        return redirect(route('admin.links.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditLinkRequest $request, $id)
    {
        $link = Link::findById($id)->first();

        $link->update($request->all());
        return response()->json(['id' => $link->id, 'title' => $link->title, 'url' => $link->url, 'description' => $link->description])->setCallback($request->input('callback'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EditLinkRequest $request, $id)
    {
        $link = Link::findById($id)->first();

        $link->delete();
        
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
    
    /**
     * 
     */
    public function importTweet()
    {
           /*
     * 
     * 
     * created_at
id_str
text
urls[]
 expanded_url
 display_url
media[]
 media_url_https
 sizes[]
  medium
    w
    h
    resize (fit/crop)
  thumb
    ...
  large
    ...
  small
    ---

user
 screen_name
 name
     */
        //$twitter = Twitter::getUserTimeline(['screen_name' => 'thujohn', 'count' => 20, 'format' => 'json']);
        $twitter = json_decode(file_get_contents(__DIR__ . '\twitter.json'));
        
        foreach ($twitter as $twit) {
            if($twit->in_reply_to_status_id == null) {
                $tweet = TwitterLink::firstOrNew(['id_twitter' => $twit->id_str]);
                $created_at = new \DateTime($twit->created_at);
                $tweet->created_at = $created_at->format('Y-m-d H:i:s');
                $text = $twit->text;
                $tweet->user_name = $twit->user->name;
                $tweet->user_id = $twit->user->screen_name;

                if(count($twit->entities->urls) > 0) {
                    foreach ($twit->entities->urls as $url) {
                        
                        $text = str_ireplace($url->url, "<a href='{$url->expanded_url}'>{$url->display_url}</a>", $text);
                        //preg_replace("/https:\/\/t.co\/DoNgT1s8Zl/i", "t", $input_lines);
                        /*
                         *           +"url": "https://t.co/DoNgT1s8Zl"
          +"expanded_url": "http://leomaradan.github.io/toolbox/"
          +"display_url": "leomaradan.github.io/toolbox/"
                         */
                    }
                }
                
                $tweet->text = $text;

                $tweet->save();
            }
            
            /*if(isset($twit['entities']['media'])) {
                
                /*
                 * 
                 * type
display_url
url
config
link_id
                 */
            //}*/
        }
        //
        
        dd($twitter);
        /*
         * created_at
id_twitter
text
user_name
user_id
         */
    }
}
