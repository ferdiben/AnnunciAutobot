<?php
error_reporting(E_ALL);

$RedisClient = new Redis ();

$RedisClient ->connect( “tcp://ec2-34-252-182-25.eu-west-1.compute.amazonaws.com”, “13419”, “NULL”, “150”);


 
session_start();
 
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
 
echo $count;
 
$_SESSION['count'] = ++$count;
 
?>
