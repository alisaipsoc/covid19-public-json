<?php

/**
 * File Name        : cases_malaysia.php
 * Project Name     : Covid-19 Malaysia's Cases JSON
 * Author           : amlxv
 * Github Profile   : https://github.com/amlxv
 * Project Link     : https://github.com/amlxv
 * 
 */

/**
 * Configure the MoH-Malaysia/covid19-public's GitHub csv url.
 * @var string $url
 * 
 */
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/cases_malaysia.csv";

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
 * Collect all dates available in cases_malaysia.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    array_push($dates, $data[$i][0]);
}

$cases_malaysia = [];

$details = [
    'cases_new',
    'cluster_import',
    'cluster_religious',
    'cluster_community',
    'cluster_highRisk',
    'cluster_education',
    'cluster_detentionCentre',
    'cluster_workplace',
];

/**
 * :: Rearrange.
 * 
 */
foreach ($dates as $date) {
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i][0] == $date) {
            $j = 1;
            foreach ($details as $detail) {
                $cases_malaysia[$date][$detail] = (!empty($data[$i][$j]) ? $data[$i][$j] : '0');
                $j++;
            }
        }
    }
}

/**
 * Encode the cases_malaysia as a JSON.
 * 
 */
$cases_malaysia = json_encode($cases_malaysia, JSON_PRETTY_PRINT);

echo $cases_malaysia;