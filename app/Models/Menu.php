<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;
use Route;

class Menu extends Model {

    protected $fillable = ["zone", "parent", "type", "title", "link", "order"];
    
    public static function getZones() {
        return DB::table('menus')->select('zone')->distinct()->pluck('zone')->toArray();
    }

    public static function getMenu($zone) {

        $query = Menu::findTopLevelByZone($zone)->get();
        $response = [];


        foreach ($query as $item) {
            $responseItem = Menu::formatItem($item);

            if (is_null($item->type)) {
                $responseItem['submenu'] = array();

                $subquery = Menu::findByParent($item->id)->get();

                foreach ($subquery as $subitem) {
                    $responseItem['submenu'][] = Menu::formatItem($subitem);
                }
            }

            $response[] = $responseItem;
        }

        return $response;
    }

    private static function formatItem($data) {


        $responseItem = $data->toArray();

        switch ($data->type) {
            case 'internalLink':
                if(Route::has($data->link)) {
                    $responseItem['href'] = route($data->link);
                } else {
                    $responseItem['href'] = $data->link;
                }
                break;
            case 'externalLink':
                $responseItem['href'] = $data->link;
                break;
            case 'separator':
                $responseItem = ['divider' => 'true'];
                break;
        }

        return $responseItem;
    }

    public function scopeFindTopLevelByZone($query, $q) {
        return $query->where([
                        ['zone', $q],
                        ['parent', null]
                ])->orderBy('order');
    }

    public function scopeFindByParent($query, $q) {
        return $query->where('parent', $q)->orderBy('order');
    }

}
