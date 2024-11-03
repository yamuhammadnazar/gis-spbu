<?php

//Menghubungkan file php ini ke basis data
$connection = mysqli_connect(
    "localhost",
    "root",
    "",
    "spbu_db",
    "3306"
);

function send_query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

var_dump(send_query("SELECT * FROM spbu_tb"));

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Read SPBU</title>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
          
          <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

            <style>
                #peta { height: 720px; }
            </style>
   </head>
   <body>
      <?php $query = "SELECT 
      id,
      name,
      address,
      ST_X(coordinate) AS lat,
      ST_Y(coordinate) AS lng FROM spbu_tb" ?>
      <?php $spbus = send_query($query); ?>
      <?php foreach($spbus as $spbu): ?>
      <?= $spbu['name']; ?>
      <?= $spbu['address']; ?>
      <br>
      <?php endforeach; ?>
      <div id="peta"></div>
      
      <script>
         var map = L.map('peta').setView([-0.02543844487523898, 109.33669538729531], 13);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{
         minZoom:5,
         maxZoom: 300,}).addTo(map);

         var spbus = <?php echo json_encode($spbus); ?>;
         spbus.forEach(function(row) {
            L.marker([
                row.lat, row.lng
            ]).addTo(map);
         });
      </script>
   </body>
</html>