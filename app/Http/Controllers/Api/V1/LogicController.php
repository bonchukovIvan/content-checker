<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Site;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;

class LogicController extends Controller
{
    public function index()
    {
        if (ini_get('max_execution_time') >= 30) {
            ini_set('max_execution_time', 9999);
        }
        $test = [];
        $finals = [];

        $sites = Site::with('faculty')->get();
        $groups = Group::with('values', 'faculty')->get();

        $multiHandle = curl_multi_init();

        $handles = [];

        foreach ($sites as $site) {
            
            $values = [];

            $handle = self::init_curl_handle($site->link);

            curl_multi_add_handle($multiHandle, $handle);

            $handles[] = ['site' => $site, 'handle' => $handle];
        }

        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running);

        foreach ($handles as $handleInfo) {
            $site = $handleInfo['site'];
            $handle = $handleInfo['handle'];
            $site_pages = self::crawl_links($handleInfo['site']->link);
            $test['link'] = $handleInfo['site']->link;
            $test['faculty'] = $handleInfo['site']->faculty;

            $content = curl_multi_getcontent($handle);
            $pages_content = self::get_multiple_content($site_pages);
            $scss = 0;
            $buff = [];
            foreach ($groups as $group) {
                $group_arr = [];
                $res = [];
                $group_dep_id = [];
                foreach($group->departaments as $dep) {
                    array_push($group_dep_id, $dep->id);
                }
                if (!in_array($site->departament_id, $group_dep_id)) {
                    continue 1;
                }
                foreach ($group->values as $value) {
                    if ($group->faculty_id && $site->faculty_id) {
                        if ($group->faculty->name != $site->faculty->name) {
                            continue 2;
                        }
                    }
                    if ($site->link === 'https://kvp.sumdu.edu.ua' && $group->faculty_id) {
                        continue 2;
                    }
                    
                    $result = str_contains(mb_strtolower($content), mb_strtolower(trim($value->search_value)));
                    self::set_result($result, $group_arr, $group, $value);
                    array_push($group_arr, ['name' => $group->name, 'value' => $value->search_value, 'result' => $result]);
                    if(!$result) {
                        $result = self::crawl_pages($pages_content, $value);
                        self::set_result($result, $group_arr, $group, $value);
                    }
                }
                $res['result'] = self::array_any($group_arr, true);
                $res['name'] = $group->name;

                array_push($buff, $res);
            }
            $we = 0;
            foreach ($buff as $b) {
                $we++;
                if ($b['result'] === true) {
                    $scss++;
                }
            }
            
            $test['success'] = floor(($scss / $we) * 100);
            $test['values'] = $buff;
            array_push($finals, $test);

            curl_multi_remove_handle($multiHandle, $handle);
        }

        curl_multi_close($multiHandle);
        
        $groupedWebsites = collect($finals)->groupBy(function ($item) {
            return $item['faculty'] ? $item['faculty']['name'] : 'Головні сайти підрозділів';
        });

        $pdf = Pdf::loadView('pdf', compact('groupedWebsites'));
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('font-family', 'DejaVu Sans');

        return $pdf->download('t3.pdf');
        
    }

    static public function crawl_pages($pages_content, $value) {
        foreach($pages_content as $page_content) {
            $result = str_contains(mb_strtolower($page_content), mb_strtolower(trim($value->search_value)));
            if($result) return $result;
        }
    }
    static public function set_result($result, &$group_arr, $group, $value) {
        
        array_push($group_arr, ['name' => $group->name, 'value' => $value->search_value, 'result' => $result]);
    }
    static private function init_curl_handle($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        return $ch;
    }

    static public function array_any(array $array, $fn)
    {
        foreach ($array as $item) {
            if ($item['result'] === true) {
                return true;
            }
        }
        return false;
    }

    static public function crawl_links($url) {
        $dom = new \DOMDocument();
        @$dom->loadHTMLFile($url);
    
        $xpath = new \DOMXPath($dom);
    
        // Select all anchor elements on the page
        $anchorElements = $xpath->query('//li//a');
    
        $site_links = [];
    
        foreach ($anchorElements as $anchorElement) {
            if (str_starts_with($anchorElement->getAttribute('href'), '/')) {
                array_push($site_links, $url . $anchorElement->getAttribute('href'));
            } 
            elseif (str_starts_with($anchorElement->getAttribute('href'), $url)) {
                array_push($site_links, $anchorElement->getAttribute('href'));
            }
        }
    
        return array_unique($site_links);
    }
    static public function get_contents_array($handles) {
        $contents_array = [];
        foreach($handles as $handle) {
            array_push($contents_array, curl_multi_getcontent($handle));
        }
        return $contents_array;
    }

    private static function get_handles($domains) {
        $handles = array();
        foreach($domains as $domain) {
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $domain);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_VERBOSE, false);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

            if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
                curl_setopt($handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            }

            $handles[$domain] = $handle;
        }

        return $handles;
    }

    private static function add_handles_to_multi($mh, $handles) {
        foreach($handles as $handle) {
            curl_multi_add_handle($mh, $handle);
        }
    }

    private static function close_handle($mh, $handles) {
        foreach($handles as $handle) {
            curl_multi_remove_handle($mh, $handle);
        }
        curl_multi_close($mh);
    }

    public static function get_multiple_content($pages) {
        $handles = self::get_handles($pages);

        $mh = curl_multi_init();
        self::add_handles_to_multi($mh, $handles);
    
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);

        self::close_handle($mh, $handles);
        return self::get_contents_array($handles);
    } 

    static public function get_indexed_page($site) {
        if(str_starts_with($site, 'https://')) {
            $site = str_replace('https://', '', $site);
        }
        elseif(str_starts_with($site, 'http://')) {
            $site = str_replace('http://', '', $site);
        }
        
        $api_key = \config('app.search_api_key');
        $cx = \config('app.search_cx');
        $query = "https://www.googleapis.com/customsearch/v1?key={$api_key}&cx={$cx}&q=site:{$site}";
        $count = 0;
        for ($i = 0; $i < 4; $i++) {
            $json_query = json_decode(file_get_contents($query));
            $count += $json_query->queries->request[0]->totalResults;
        }
        // $json_query = json_decode(file_get_contents($query));
        // return $json_query->queries->request[0]->totalResults;
        return $count/5;
    }
}
