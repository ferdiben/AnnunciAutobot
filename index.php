<?php
error_reporting(E_ALL);
session_start();
session_destroy();
 if($_ENV['REDIS_URL']) {
    $redisUrlParts = parse_url($_ENV['REDIS_URL']);
    ini_set('session.save_handler','redis');
    ini_set('session.save_path',"tcp://$redisUrlParts[ec2-34-252-182-25.eu-west-1.compute.amazonaws.com]:$redisUrlParts[13419]?auth=$redisUrlParts[p05ebe76c4296539328f91efde721822040f16c9e599be903602914d21c27a55e]");
  }
 
?>
