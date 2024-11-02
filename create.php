<?php

$connection = mysqli_connect(
    "localhost",
    "root",
    "",
    "spbu_db",
    "3306"
);


// Mengambil data dari form di create.html
$name = $_POST('inputName');
$address = $_POST('address');
$latitude = $_POST('latitude');
$longitude = $_POST('longitude');

// Mempersiapkan Query simpan data ke tabel
$query = "INSERT INTO spbu_tb
    (name, address, coordinate)
    VALUES (
        '$name',
        '$address',
        ST_GeomFromText('POINT ($latitude $longitude)', 4326))
    )";

// Mengirim Query ke Mysql
mysqli_query($connection, $query);
?>