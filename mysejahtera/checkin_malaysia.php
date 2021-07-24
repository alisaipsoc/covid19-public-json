<?php

/**
 * File Name        : checkin_malaysia.php
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
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/mysejahtera/checkin_malaysia.csv";

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
$checkin_malaysia = [];

/**
 * Retrieve all dates available in checkin_malaysia.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    if (!in_array($data[$i][0], $dates)) {
        array_push($dates, $data[$i][0]);
    }
}

$details = [
    'checkins',
    'unique_ind',
    'unique_loc',
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
                $checkin_malaysia[$date][$detail] = $data[$i][$j];
                $j++;
            }
        }
    }
}

/**
 * Encode the checkin_malaysia as a JSON.
 * 
 */
$checkin_malaysia = json_encode($checkin_malaysia, JSON_PRETTY_PRINT);

echo $checkin_malaysia;