<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Site;

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
            $buff = [];
            foreach($groups as $group) 
            {
                $group_arr = [];
                $res = [];
                foreach($group->values as $value) 
                {
                    if ($group->faculty_id && $site->faculty_id)
                    {
                        if ($group->faculty->name != $site->faculty->name) 
                        {
                            continue 2;
                        }
                    }
                    $result = str_contains(mb_strtolower($content), mb_strtolower(trim($value->search_value)));
                  
                    array_push($group_arr, ['name' => $group->name, 'value' => $value->search_value,  'result' => $result]);  
                }

                $res['result'] = self::array_any($group_arr, true);
                $res['name'] = $group->name;   
                
                array_push($buff, $res);
            }
            $we = 0;
            foreach($buff as $b)
            {
                $we++;
                if($b['result'] === true) 
                {
                    $scss++;
                }
            }

            $test['success'] = floor(($scss/$we)*100);
            $test['values'] = $buff;
            array_push($finals, $test);
            
        }
        return response($finals);
    }

    static public function file_get_contents_curl($url) 
    {
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

    static public function array_any(array $array, $fn) 
    {
        foreach ($array as $item) 
        {
            if ($item['result'] === true)
            {
                return true;
            }
        }
        return false;
    }
    
}
