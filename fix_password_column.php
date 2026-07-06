<?php
$db = new mysqli('localhost','root','','db-gis-sekolah');
if ($db->connect_error) {
    die('Error: '.$db->connect_error);
}

// Ubah ukuran kolom password
$sql = "ALTER TABLE tbl_user MODIFY password VARCHAR(255)";
if ($db->query($sql) === TRUE) {
    echo "✓ Kolom password berhasil diubah ke VARCHAR(255)".PHP_EOL;
} else {
    echo "✗ Error: ".$db->error.PHP_EOL;
}
$db->close();
