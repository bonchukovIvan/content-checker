<?php

$url = 'https://sumdu.edu.ua';

function crawl_all_links($url) {
    $dom = new DOMDocument();
    @$dom->loadHTMLFile($url);

    $xpath = new DOMXPath($dom);

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

print_r(crawl_all_links($url));
