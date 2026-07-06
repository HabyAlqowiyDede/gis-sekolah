<?php
$db = new mysqli('localhost','root','','db-gis-sekolah');
if ($db->connect_error) {
    die('CONN_ERR: '.$db->connect_error);
}
$res = $db->query('DESCRIBE tbl_user');
while($r = $res->fetch_assoc()){
    if($r['Field'] == 'password'){
        echo $r['Field'].' | '.$r['Type'].' | '.$r['Null'].' | '.$r['Key'].PHP_EOL;
        break;
    }
}
$db->close();
