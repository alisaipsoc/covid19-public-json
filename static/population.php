<?php

/**
 * File Name        : population.php
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
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/static/population.csv";

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

// All states will be gathered into the $states variable
$states = [];

// This the result variable.
$population = [];

/**
 * Retrieve all states available in population.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    if (!in_array($data[$i][0], $states)) {
        array_push($states, $data[$i][0]);
    }
}

$details = [
    'idxs',
    'pop',
    'pop_18',
    'pop_60'
];

/**
 * :: Rearrange.
 * 
 */
foreach ($states as $state) {
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i][0] == $state) {
            $j = 1;
            foreach ($details as $detail) {
                $population[$state][$detail] = $data[$i][$j];
                $j++;
            }
        }
    }
}

/**
 * Encode the population as a JSON.
 * 
 */
$population = json_encode($population, JSON_PRETTY_PRINT);

echo $population;