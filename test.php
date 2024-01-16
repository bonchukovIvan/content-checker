<?php

$site = 'sumdu.edu.ua';
$api_key = 'AIzaSyChf9E3gWI_Wkcvw-QsOncT4lYaKplNrgI';
$cx = '4208b2f7e0c9b49e1';

$query = 'https://www.googleapis.com/customsearch/v1?key='.$api_key.'&cx='.$cx.'&q=site:'.$site;
$json_query = json_decode(file_get_contents($query));
print_r(PHP_EOL. '-------------------'.PHP_EOL);
print_r($json_query->queries->request[0]->totalResults);


