<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter;
use App\Models\TwitterLink;
use App\Models\TwitterLinkMedia;


class TwitterSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:twitter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync twitter data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $twitter = Twitter::getUserTimeline(['screen_name' => config('twitter.screen_name'), 'count' => 20]);
        
        foreach ($twitter as $tweet) {
            //if($tweet->in_reply_to_status_id == null) {
                $this->generateTweet($tweet);
            //}
        }
    }
    
    private function generateTweetMedia(TwitterLink $tweet, $medias) {
        //id_str
        foreach($medias as $media) {
            
        
            $tlm = TwitterLinkMedia::firstOrNew(['id_twitter' => $media->id_str]);
        
            $tlm->type = $media->type;
            
            $tlm->display_url = $media->display_url;
            
            $tlm->url = $media->url;
            
            $tlm->config = json_encode($media->sizes->medium);
            
            $tlm->link_id = $tweet->id;
            
            $tlm->save();
                
        }
    }
    
    private function generateTweet($tweet) {
        
        $medias = [];
        
            $twitterLink = TwitterLink::firstOrNew(['id_twitter' => $tweet->id_str]);
            $twitterLink->deactivateTouchWatch();
                $updated_at = new \DateTime($tweet->created_at);
                $twitterLink->updated_at = $updated_at->format('Y-m-d H:i:s');
                $text = $tweet->text;
                $twitterLink->user_name = $tweet->user->name;
                $twitterLink->user_id = $tweet->user->screen_name;
                
                $twitterLink->reply_to = $tweet->in_reply_to_status_id;
                

                if(count($tweet->entities->urls) > 0) {
                    foreach ($tweet->entities->urls as $url) {
                        
                        $text = str_ireplace($url->url, "<a href='{$url->expanded_url}'>{$url->display_url}</a>", $text);
                    }
                }
                
                if(count($tweet->entities->media) > 0) {
                    foreach ($tweet->entities->media as $media) {
                        
                        $text = str_ireplace($media->url, "<a href='{$media->expanded_url}'>{$media->display_url}</a>", $text);
                        
                        if($media->type == "photo") {
                            //$this->generateTweetMedia($tweet->id_str, $medias);
                            $medias[] = $media;
                        }
                    }
                }                
                
                if(isset($tweet->extended_entities) && isset($tweet->extended_entities->media)) {
                    foreach ($tweet->extended_entities->media as $media) {
                        
                        $text = str_ireplace($media->url, "<a href='{$media->expanded_url}'>{$media->display_url}</a>", $text);
                        
                        if($media->type == "photo") {
                            //$this->generateTweetMedia($tweet->id_str, $medias);
                            $medias[] = $media;
                        }                        
                    }
                }
                
                if(!$twitterLink->isTouched('text')) {
                    $twitterLink->text = $text;
                }

                $twitterLink->save();
                
                $this->generateTweetMedia($twitterLink, $medias);
    }
}
