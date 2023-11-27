<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Site;

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

        // Initialize the cURL multi-handle
        $multiHandle = curl_multi_init();

        $handles = [];

        foreach ($sites as $site) {
            
            $values = [];

            // Create a new cURL handle for each site
            $handle = self::init_curl_handle($site->link);

            // Add the handle to the multi-handle
            curl_multi_add_handle($multiHandle, $handle);

            $handles[] = ['site' => $site, 'handle' => $handle];
        }

        // Execute all queries simultaneously, and continue processing until all are complete
        $running = null;
        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running);

        // Retrieve results from each handle
        foreach ($handles as $handleInfo) {
            $site = $handleInfo['site'];
            $handle = $handleInfo['handle'];
            $site_pages = self::crawl_links($handleInfo['site']->link);
            $test['link'] = $handleInfo['site']->link;
            $content = curl_multi_getcontent($handle);
            $pages_content = self::get_multiple_content($site_pages);
            $scss = 0;
            $buff = [];
            $t = '';
            foreach ($groups as $group) {
                $group_arr = [];
                $res = [];

                foreach ($group->values as $value) {
                    if ($group->faculty_id && $site->faculty_id) {
                        if ($group->faculty->name != $site->faculty->name) {
                            continue 2;
                        }
                    }
                    $result = str_contains(mb_strtolower($content), mb_strtolower(trim($value->search_value)));
                    array_push($group_arr, ['name' => $group->name, 'value' => $value->search_value, 'result' => $result]);
                    if(!$result) {
                        foreach($pages_content as $page_content) {
                            $result = str_contains(mb_strtolower($page_content), mb_strtolower(trim($value->search_value)));
                            array_push($group_arr, ['name' => $group->name, 'value' => $value->search_value, 'result' => $result]);
                            if($result) {
                                break;
                            }
                        }
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

            // Remove the handle from the multi-handle
            curl_multi_remove_handle($multiHandle, $handle);
        }

        // Close the multi-handle
        curl_multi_close($multiHandle);

        return response($finals);
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
}
