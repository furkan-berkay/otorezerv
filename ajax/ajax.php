<?php
require_once("../includes/init.php");

if (isset($_GET["action"])) {
    if ($_GET["action"] === "set_company" && $_SERVER["REQUEST_METHOD"] === "POST") {
        $companyId = intval($_POST["company_id"]);

        $_SESSION["selected_company_id"] = $companyId;

        $stmt = $db->prepare("SELECT name FROM companies WHERE id = ?");
        $stmt->execute([$companyId]);
        $company = $stmt->fetch();

        if ($company) {
            $_SESSION["selected_company_name"] = $company["name"];
            echo json_encode(["success" => true, "name" => $company["name"]]);
        }
        else {
            echo json_encode(["success" => false, "error" => "Firma bulunamadı"]);
        }
    }
    elseif ($_GET["action"] === "get_companies") {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(["success" => false, "error" => "Kullanıcı giriş yapmamış"]);
            exit;
        }
        $userId = intval($_SESSION['user_id']);

        $stmt = $db->prepare("
        SELECT c.id, c.name 
        FROM companies c
        JOIN company_user cu ON cu.company_id = c.id
        WHERE cu.user_id = ?
        ORDER BY c.name ASC
    ");
        $stmt->execute([$userId]);
        $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($companies);
    }
    elseif ($_GET['action'] === 'add_vehicle') {
        // POST verileri al
        $companyId = $_POST['company_id'] ?? null;
        $title = $_POST['title'] ?? null;

        if (!$companyId || !$title) {
            echo json_encode(['success' => false, 'error' => 'Firma ve Araç Başlığı zorunludur.']);
            exit;
        }

        $sql = "INSERT INTO vehicles 
            (company_id, title, brand, model, year, price, is_for_rent, is_for_sale, status, plate, is_plate_hidden, km, is_km_hidden, location_address, gear_type, fuel_type, engine_size, horse_power, color, body_type, description, rental_type, min_rent_duration, max_rent_duration, tramers_price, traction, rental_km_limit, over_km_price, heavy_damage_record)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $db->prepare($sql);

        $result = $stmt->execute([
            $companyId,
            $title,
            $_POST['brand'] ?? null,
            $_POST['model'] ?? null,
            $_POST['year'] ?? null,
            $_POST['price'] ?? null,
            isset($_POST['is_for_rent']) ? (int)$_POST['is_for_rent'] : 0,
            isset($_POST['is_for_sale']) ? (int)$_POST['is_for_sale'] : 0,
            $_POST['status'] ?? 'available',
            $_POST['plate'] ?? null,
            isset($_POST['is_plate_hidden']) ? (int)$_POST['is_plate_hidden'] : 0,
            $_POST['km'] ?? null,
            isset($_POST['is_km_hidden']) ? (int)$_POST['is_km_hidden'] : 0,
            $_POST['location_address'] ?? null,
            $_POST['gear_type'] ?? 'automatic',
            $_POST['fuel_type'] ?? 'petrol',
            $_POST['engine_size'] ?? null,
            $_POST['horse_power'] ?? null,
            $_POST['color'] ?? null,
            $_POST['body_type'] ?? null,
            $_POST['description'] ?? null,
            $_POST['rental_type'] ?? 'none',
            $_POST['min_rent_duration'] ?? null,
            $_POST['max_rent_duration'] ?? null,
            $_POST['tramers_price'] ?? null,
            $_POST['traction'] ?? null,
            $_POST['rental_km_limit'] ?? null,
            $_POST['over_km_price'] ?? null,
            isset($_POST['heavy_damage_record']) ? (int)$_POST['heavy_damage_record'] : 0
        ]);

        if ($result) {
            echo json_encode(['success' => true]);
        }
        else {
            echo json_encode(['success' => false, 'error' => 'Veritabanı hatası.']);
        }
    }
    elseif ($_GET['action'] === 'getCountries') {
        $stmt = $db->query("SELECT id, name FROM countries ORDER BY name ASC");
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
        }
    }
    elseif ($_GET['action'] === 'getCities' && isset($_POST['country_id'])) {
        $countryId = (int)$_POST['country_id'];
        $stmt = $db->prepare("SELECT id, name FROM cities WHERE country_id = ? ORDER BY name ASC");
        $stmt->execute([$countryId]);
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
        }
    }
    elseif ($_GET['action'] === 'getDistricts' && isset($_POST['city_id'])) {
        $cityId = (int)$_POST['city_id'];
        $stmt = $db->prepare("SELECT id, name FROM districts WHERE city_id = ? ORDER BY name ASC");
        $stmt->execute([$cityId]);
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
        }
    }
    elseif ($_GET['action'] === 'get_vehicles') {

        $columns = [
            'id', 'title', 'brand', 'model', 'year', 'price',
            'is_for_rent', 'is_for_sale', 'status', 'created_at', 'plate',
            'is_plate_hidden', 'km', 'is_km_hidden', 'location_address',
            'location_country_id', 'location_city_id', 'location_district_id',
            'gear_type', 'fuel_type', 'engine_size', 'horse_power', 'color',
            'body_type', 'description', 'rental_type', 'min_rent_duration',
            'max_rent_duration', 'tramers_price', 'traction',
            'rental_km_limit', 'over_km_price', 'heavy_damage_record'
        ];

        // Gelen DataTables parametreleri
        $draw = intval($_POST['draw'] ?? 1);
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);
        if ($length === -1) {
            // Tüm kayıtlar
            $length = 1000000; // ya da çok büyük bir sayı koy
        }
        $searchValue = $_POST['search']['value'] ?? '';

        // ORDER BY işleme
        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDir = $_POST['order'][0]['dir'] ?? 'desc';
        $orderDir = strtolower($orderDir) === 'asc' ? 'ASC' : 'DESC';

        // 1. Toplam kayıt sayısı
        $totalRecords = $db->query("SELECT COUNT(*) FROM vehicles")->fetchColumn();

        // 2. Arama varsa WHERE kısmı oluşturulacak
        $searchSql = "";
        $searchParams = [];

        if ($searchValue !== '') {
            $searchSqlParts = [];
            foreach ($columns as $col) {
                if (in_array($col, ['id', 'year', 'price', 'is_for_rent', 'is_for_sale', 'created_at', 'is_plate_hidden', 'km', 'is_km_hidden', 'location_country_id', 'location_city_id', 'location_district_id', 'engine_size', 'horse_power', 'min_rent_duration', 'max_rent_duration', 'tramers_price', 'rental_km_limit', 'over_km_price', 'heavy_damage_record'])) {
                    // Numeric veya tarih kolonlar için LIKE değil eşitlik denemesi yapılabilir, ama burada LIKE yapabiliriz kolaylık için
                    $searchSqlParts[] = "$col LIKE ?";
                    $searchParams[] = "%$searchValue%";
                }
                else {
                    $searchSqlParts[] = "$col LIKE ?";
                    $searchParams[] = "%$searchValue%";
                }
            }
            $searchSql = "WHERE (" . implode(" OR ", $searchSqlParts) . ")";
        }

        // 3. Toplam filtrelenmiş kayıt sayısı
        if ($searchSql) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM vehicles $searchSql");
            $stmt->execute($searchParams);
            $filteredRecords = $stmt->fetchColumn();
        }
        else {
            $filteredRecords = $totalRecords;
        }

        $start = (int)$start;
        $length = (int)$length;

        $sql = "SELECT " . implode(", ", $columns) . " FROM vehicles $searchSql ORDER BY $orderColumn $orderDir LIMIT $start, $length";

        $stmt = $db->prepare($sql);
        $stmt->execute($searchParams); // sadece arama parametreleri

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // JSON cevabı oluştur
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data" => $data
        ]);
    }
    elseif ($_GET['action'] === 'save_columns') {
        $selectedColumns = $_POST['columns'] ?? [];

        $userId = $_SESSION["user_id"] ?? null;
        $tableName = "vehicles-table";

        if ($userId && is_array($selectedColumns)) {
            // Önce eski tercihleri sil
            $deleteQuery = $db->prepare("DELETE FROM user_column_preferences WHERE user_id = ? AND table_name = ?");
            $deleteQuery->execute([$userId, $tableName]);

            // Yeni tercihleri kaydet
            $insertQuery = $db->prepare("INSERT INTO user_column_preferences (user_id, table_name, column_name) VALUES (?, ?, ?)");
            foreach ($selectedColumns as $column) {
                $insertQuery->execute([$userId, $tableName, $column]);
            }

            echo json_encode(['success' => true, 'message' => 'Sütun tercihleri kaydedildi.']);
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Geçersiz veri.']);
        }
    }


    else {
            echo json_encode(["success" => false, "error" => "Geçersiz istek"]);
        }
}
else {
    echo json_encode(["success" => false, "error" => "Action parametresi eksik"]);
}

exit;
