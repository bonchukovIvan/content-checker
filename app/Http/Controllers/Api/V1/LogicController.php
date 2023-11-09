<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Site;
use App\Models\Value;

class LogicController extends Controller
{
    public function index() 
    {
        $test = [];
        $finals = [];

        $sites = Site::with('faculty')->get();
        $groups = Group::with('values', 'faculty')->get();
        foreach($sites as $site) 
        {   
            $test['link'] = $site->link;
            $values = [];
            $content = self::file_get_contents_curl($site->link);
            $scss = 0;
            foreach($groups as $group) 
            {
                foreach($group->values as $value) 
                {
                    if ($group->faculty_id)
                    {
                        if ($group->faculty->name != $site->faculty->name) 
                        {
                            continue;
                        }
                    }
                    if (str_contains(strtolower($content), strtolower(trim($value->search_value))))
                    {
                        array_push($values, ['name' => $group->name, 'result' => true]);
                        $scss++;
                        break;
                    }
                    array_push($values, ['name' => $group->name, 'result' => false]);
                    
                }
            }
            $test['success'] = floor(($scss/count($values))*100);
            $test['values'] = $values;
            array_push($finals, $test);
   
        }
        return response($finals);
    }

    static public function file_get_contents_curl($url) {
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
    
        $data = curl_exec($ch);
        curl_close($ch);
    
        return $data;
    }
}
