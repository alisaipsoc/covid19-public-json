<?php

/**
 * File Name        : checkin_malaysia_time.php
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
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/mysejahtera/checkin_malaysia_time.csv";

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
$checkin_malaysia_time = [];

/**
 * Retrieve all dates available in checkin_malaysia_time.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    if (!in_array($data[$i][0], $dates)) {
        array_push($dates, $data[$i][0]);
    }
}

/**
 * :: Rearrange.
 * 
 * info : The index starting is from 1
 * 
 */
foreach ($dates as $date) {
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i][0] == $date) {
            $j = 1;
            $y = 1;
            foreach (range(1, 48) as $num) {
                $checkin_malaysia_time[$date][$y] = $data[$i][$j];
                $j++;
                $y++;
            }
        }
    }
}

/**
 * Encode the checkin_malaysia_time as a JSON.
 * 
 */
$checkin_malaysia_time = json_encode($checkin_malaysia_time, JSON_PRETTY_PRINT);

echo $checkin_malaysia_time;