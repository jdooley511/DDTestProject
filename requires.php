<?php
//start the session
session_start();
date_default_timezone_set('America/New_York');

//set up classes
require 'classes/Lead.php';
require 'classes/Order.php';
require 'classes/Ad.php';
require 'functions.php';
require 'constants.php';

//clear output buffer
ob_end_clean();
?>