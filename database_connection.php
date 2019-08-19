<?php

//database_connection.php
$DBHOST = getenv('DBHOST');
$DBUSER = getenv('DBUSER');
$DBNAME = getenv('DBNAME');
$DBPASS = getenv('DBPASS');
$connect = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS);



?>
