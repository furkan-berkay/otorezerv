<?php

$predefinedColors = [
    "#000000" => "Siyah",
    "#FFFFFF" => "Beyaz",
    "#808080" => "Gri",
    "#FF0000" => "Kırmızı",
    "#0000FF" => "Mavi",
    "#8B0000" => "Bordo",
];


$damageParts = [
    "front_bumper", "front_hood", "roof", "front_right_mudguard",
    "front_right_door", "rear_right_door", "rear_right_mudguard",
    "front_left_mudguard", "front_left_door", "rear_left_door",
    "rear_left_mudguard", "rear_hood", "rear_bumper"
];

function getCompanyName($companyId) {
    global $db;
    $stmt = $db->prepare("SELECT name FROM companies WHERE id = ?");
    $stmt->execute([$companyId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['name'] : "Bilinmeyen";
}

function getUserCompanies($userId) {
    global $db;
    $stmt = $db->prepare("
        SELECT c.id, c.name, ce.role FROM companies c JOIN company_user ce ON ce.company_id = c.id WHERE ce.user_id = ?
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDurationUnitLabel($unit) {
    return [
        'gun' => 'Gün',
        'ay' => 'Ay',
        'yil' => 'Yıl'
    ][$unit] ?? null;
}

function getCurrencySymbol($currency) {
    return [
        'TRY' => '₺',
        'USD' => '$',
        'EUR' => '€'
    ][$currency] ?? null;
}

function print_c($text) {
    echo "<pre>";
    print_r($text);
    echo "</pre>";
}

