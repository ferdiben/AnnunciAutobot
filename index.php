<?php
error_reporting(E_ALL);
ini_set('session.save_handler', 'redis');
 
ini_set('session.save_path', "redis://h:p05ebe76c4296539328f91efde721822040f16c9e599be903602914d21c27a55e@ec2-34-252-182-25.eu-west-1.compute.amazonaws.com:13419");
 
//echo ini_get('session.save_path');
 
session_start();
 
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
 
echo $count;
 
$_SESSION['count'] = ++$count;
 
?>
