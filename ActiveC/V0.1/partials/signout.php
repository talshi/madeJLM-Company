<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 21/05/2016
 * Time: 18:58
 */
session_start();
session_destroy();
header("location: ../#/login");
exit;

?>

