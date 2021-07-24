<?php

/**
 * File Name        : trace_malaysia.php
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
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/mysejahtera/trace_malaysia.csv";

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

// All states will be gathered into the $dates variable
$dates = [];

// This the result variable.
$trace_malaysia = [];

/**
 * Retrieve all dates available in trace_malaysia.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    if (!in_array($data[$i][0], $dates)) {
        array_push($dates, $data[$i][0]);
    }
}

$details = [
    'casual_contacts',
    'hide_large',
    'hide_small',
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
                $trace_malaysia[$date][$detail] = $data[$i][$j];
                $j++;
            }
        }
    }
}

/**
 * Encode the trace_malaysia as a JSON.
 * 
 */
$trace_malaysia = json_encode($trace_malaysia, JSON_PRETTY_PRINT);

echo $trace_malaysia;