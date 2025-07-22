<?php
require '../includes/db.php'; // $db = new PDO(...)

$countryName = "Türkiye";

// 1. Ülkeyi ekle
$stmt = $db->prepare("INSERT INTO countries (name) VALUES (?)");
$stmt->execute([$countryName]);
$countryId = $db->lastInsertId();

// 2. TürkiyeAPI'den illeri çek
$response = file_get_contents("https://turkiyeapi.dev/api/v1/provinces");
$data = json_decode($response, true);

foreach ($data["data"] as $province) {
    $cityName = $province["name"];

    // Şehri ekle
    $stmt = $db->prepare("INSERT INTO cities (country_id, name) VALUES (?, ?)");
    $stmt->execute([$countryId, $cityName]);
    $cityId = $db->lastInsertId();

    // İlçeleri ekle
    foreach ($province["districts"] as $district) {
        $districtName = $district["name"];
        $stmt = $db->prepare("INSERT INTO districts (city_id, name) VALUES (?, ?)");
        $stmt->execute([$cityId, $districtName]);
    }
}

echo "İller ve ilçeler başarıyla eklendi.";
