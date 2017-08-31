<?php
error_reporting(E_ALL);
ini_set('session.save_handler', 'redis');
 
ini_set('session.save_path', "ec2-34-252-182-25.eu-west-1.compute.amazonaws.com:13419");
 
//echo ini_get('session.save_path');
 
session_start();
 
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
 
echo $count;
 
$_SESSION['count'] = ++$count;
 
?>
