<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mayd');
define('DB_USER','root');
define('DB_PASSWORD','');
 
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

if($_GET['type'] == 'product'){
    $result = mysql_query("SELECT name FROM country where name LIKE '%".$_GET['name_startsWith']."%'");    
    $data = array();
    while ($row = mysql_fetch_array($result)) {
        array_push($data, $row['name']);    
    }    
    echo json_encode($data);
}