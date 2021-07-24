<?php

/**
 * File Name        : tests_malaysia.php
 * Project Name     : Covid-19 Malaysia's Cases JSON
 * Author           : amlxv
 * Github Profile   : https://github.com/amlxv
 * Project Link     : https://github.com/amlxv
 * 
 */

/**
 * 
 * Configure the MoH-Malaysia/covid19-public's GitHub csv url.
 * @var string $url
 * 
 */
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/tests_malaysia.csv";

/**
 * Get the csv content & explode by line.
 * @param $url
 * 
 */
$response = file_get_contents($url);

/**
 * Explode the content by line.
 * @param $response
 * 
 */
$rows = explode("\n", $response);

$data = [];

/**
 * Save result into variable (per line).
 * @var array $data
 * 
 */
foreach ($rows as $row) {
    $data[] = str_getcsv($row);
}

/**
 * Remove first & last line.
 * @param string $data
 * 
 */
array_shift($data);
array_pop($data);

$dates = [];

/**
 * Collect all dates from tests_malaysia.csv
 * 
 */

foreach ($data as $d) {
    array_push($dates, $d[0]);
}

$tests_malaysia = [];

/**
 * :: Rearrange.
 */
foreach ($dates as $date) {
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i][0] == $date) {
            $tests_malaysia[$date]['rtk-ag'] = $data[$i][1];
            $tests_malaysia[$date]['pcr'] = $data[$i][1];
        }
    }
}

/**
 * Encode the tests_malaysia as a JSON.
 * 
 */
$tests_malaysia = json_encode($tests_malaysia, JSON_PRETTY_PRINT);

echo $tests_malaysia;