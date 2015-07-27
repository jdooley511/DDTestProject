<?php
require 'requires.php';

$dailyads_file = $_FILES['dailyads_uploader']['tmp_name'];
$orders_file = $_FILES['orders_uploader']['tmp_name'];
$leads_file = $_FILES['leads_uploader']['tmp_name'];

$db = db_connect();
$schema = SCHEMA;

// DELETE all data in tables to start
// We wouldn't do this if this script was being used to continually process new data
$daily_ads_delete = "DELETE FROM {$schema}.dailyads";
$prep_query = $db->prepare($daily_ads_delete);
$prep_query->execute();

$leads_delete = "DELETE FROM {$schema}.lead";
$prep_query = $db->prepare($leads_delete);
$prep_query->execute();

$orders_delete = "DELETE FROM {$schema}.orders";
$prep_query = $db->prepare($orders_delete);
$prep_query->execute();

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
$leads_query = "INSERT INTO {$schema}.lead (Lead_ID,BirthDate,Ad_ID,State,CreatedAt) "
             . "VALUES (:lead_id,:birthdate,:ad_id,:state,:created_at);";
$leads_prep_query = $db->prepare($leads_query);
$leads_filedata = fopen($leads_file,"r");

while ($file_data = fgetcsv($leads_filedata)) {
    $this_lead_id = $file_data[0];
    $this_birthdate = $file_data[1];
    $this_ad_id = $file_data[2];
    $this_state = $file_data[3];
    $this_createdat = $file_data[4];
    $arg_array = Array ('lead_id' => $this_lead_id, "birthdate" => $this_birthdate,
                        'ad_id' => $this_ad_id, "state" => $this_state, 'created_at' => $this_createdat);
    $leads_prep_query->execute($arg_array);
}
fclose($leads_filedata);

// Process Orders File
$orders_query = "INSERT INTO {$schema}.orders (Orders_ID,Lead_ID,UnitPrice,ShippingCost,Quantity) "
             . " VALUES (:orders_id,:lead_id,:unit_price,:quantity,:shipping_cost);";
$orders_prep_query = $db->prepare($orders_query);
$orders_filedata = fopen($orders_file,"r");

while ($file_data = fgetcsv($orders_filedata)) {
    $this_orders_id = $file_data[0];
    $this_lead_id = $file_data[1];
    $this_unitprice = $file_data[2];
    $this_quantity = $file_data[3];
    $this_shippingcost = $file_data[4];
    $arg_array = Array ('orders_id' => $this_orders_id, "lead_id" => $this_lead_id,
                        'unit_price' => $this_unitprice, "quantity" => $this_quantity, 'shipping_cost' => $this_shippingcost);
    $orders_prep_query->execute($arg_array);
}
fclose($orders_filedata);
?>
<meta http-equiv="refresh" content="0;URL=index.php" /> 