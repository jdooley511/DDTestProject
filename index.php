<?php 
require 'requires.php'; 
?>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/table.css" />
        <title>Direct Digital Test Project</title>
    </head>
    <body>        
        <form enctype="multipart/form-data" method="POST" action="import_data.php" name="import_form" id="import_form">
            <label for="dailyads_uploader">Daily Ads File: </label>
            <input type="file" id="dailyads_uploader" name="dailyads_uploader" /><br>
            <label for="leads_uploader">Leads File: </label>
            <input type="file" id="leads_uploader" name="leads_uploader" /><br>
            <label for="orders_uploader">Orders File: </label>
            <input type="file" id="orders_uploader" name="orders_uploader" /><br>
            <input type="submit" value="Submit">
        </form>
        <?php echo Ad::outputAdTable(); ?>
    </body>
</html>
