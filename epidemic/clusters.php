<?php

/**
 * File Name        : clusters.php
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
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/clusters.csv";

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

$clusters = [];

/**
 * Collect all clusters available in clusters.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    array_push($clusters, $data[$i][0]);
}

$result = [];

$details = [
    'cluster',
    'state',
    'district',
    'date_announced',
    'date_last_onset',
    'category',
    'status',
    'cases_new',
    'cases_total',
    'cases_active',
    'tests',
    'icu',
    'deaths',
    'recovered'
];

/**
 * :: Rearrange.
 * 
 */
foreach ($clusters as $cluster) {
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i][0] == $cluster) {
            $j = 0;
            foreach ($details as $detail) {
                $result[$cluster][$detail] = (!empty($data[$i][$j]) ? $data[$i][$j] : '0');
                $j++;
            }
        }
    }
}

/**
 * Encode the result as a JSON.
 * 
 */
$result = json_encode($result, JSON_PRETTY_PRINT);

echo $result;