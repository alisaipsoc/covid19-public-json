<?php

/**
 * File Name        : hospital.php
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
$url = "https://raw.githubusercontent.com/MoH-Malaysia/covid19-public/main/epidemic/hospital.csv";

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
 * Collect all dates available in hospital.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    if (!in_array($data[$i][0], $dates)) {
        array_push($dates, $data[$i][0]);
    }
}

$states = [];

/**
 * Collect all dates available in hospital.csv
 * 
 */
for ($i = 0; $i < count($data); $i++) {
    if (!in_array($data[$i][1], $states)) {
        array_push($states, $data[$i][1]);
    }
}

$hospital = [];

$details = [
    'beds',
    'beds_noncrit',
    'admitted_pui',
    'admitted_covid',
    'admitted_total',
    'discharged_pui',
    'discharged_covid',
    'discharged_total',
    'hosp_covid',
    'hosp_pui',
    'hosp_noncovid'
];

/**
 * :: Rearrange.
 * 
 */
foreach ($dates as $date) {
    foreach ($states as $state) {
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i][0] == $date) {
                if ($data[$i][1] == $state) {
                    $j = 2;
                    foreach ($details as $detail) {
                        $hospital[$date][$state][$detail] = $data[$i][$j];
                        $j++;
                    }
                }
            }
        }
    }
}

/**
 * Encode the hospital as a JSON.
 * 
 */
$hospital = json_encode($hospital, JSON_PRETTY_PRINT);

echo $hospital;