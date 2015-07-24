<?php
$dailyads_file = $_FILES['dailyads_uploader']['tmp_name'];
$orders_file = $_FILES['orders_uploader']['tmp_name'];
$leads_file = $_FILES['leads_uploader']['tmp_name'];

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = 'please';
$schema = 'ddtest';

try {
    $db = new PDO("mysql:host=$hostname;dbname=mysql", $username, $password);
} 
catch (PDOException $e) {
    echo $e->getMessage();
}

// Process Daily Ads File
$dailyads_query = "INSERT INTO {$schema}.dailyads (Ad_ID,Date,Views) VALUES (:ad_id,:date,:views);";
$prep_query = $db->prepare($dailyads_query);
$dailyads_filedata = fopen($dailyads_file,"r");

while ($file_data = fgetcsv($dailyads_filedata)) {
    $this_ad_id = $file_data[0];
    $this_date = $file_data[1];
    $this_num_views = $file_data[2];
    $arg_array = Array ('ad_id' => $this_ad_id, "date" => $this_date, "views" => $this_num_views);
    $prep_query->execute($arg_array);
}
fclose($dailyads_filedata);

// Process Leads File
$dailyads_query = "INSERT INTO {$schema}.dailyads (Ad_ID,Date,Views) VALUES (:ad_id,:date,:views);";
$prep_query = $db->prepare($dailyads_query);
$dailyads_filedata = fopen($dailyads_file,"r");

while ($file_data = fgetcsv($dailyads_filedata)) {
    $this_ad_id = $file_data[0];
    $this_date = $file_data[1];
    $this_num_views = $file_data[2];
    $arg_array = Array ('ad_id' => $this_ad_id, "date" => $this_date, "views" => $this_num_views);
    $prep_query->execute($arg_array);
}
fclose($dailyads_filedata);

// Process Orders File
$dailyads_query = "INSERT INTO {$schema}.dailyads (Ad_ID,Date,Views) VALUES (:ad_id,:date,:views);";
$prep_query = $db->prepare($dailyads_query);
$dailyads_filedata = fopen($dailyads_file,"r");

while ($file_data = fgetcsv($dailyads_filedata)) {
    $this_ad_id = $file_data[0];
    $this_date = $file_data[1];
    $this_num_views = $file_data[2];
    $arg_array = Array ('ad_id' => $this_ad_id, "date" => $this_date, "views" => $this_num_views);
    $prep_query->execute($arg_array);
}
fclose($dailyads_filedata);





?>