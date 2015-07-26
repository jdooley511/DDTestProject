<?php
//start the session
session_start();
date_default_timezone_set('America/New_York');

//set up classes
require 'Lead.php';
require 'Order.php';
require 'Ad.php';
require 'functions.php';
require 'constants.php';

//clear output buffer
ob_end_clean();
?>