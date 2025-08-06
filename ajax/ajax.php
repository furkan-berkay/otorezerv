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
        if (!isset($_SESSION["user_id"])) {
            echo json_encode([
                "success" => false,
                "error" => "Kullanıcı giriş yapmamış"
            ]);
            exit;
        }
        $userId = intval($_SESSION["user_id"]);

        $stmt = $db->prepare("
            SELECT c.id, c.name FROM companies c
            JOIN company_user cu ON cu.company_id = c.id
            WHERE cu.user_id = ?
            ORDER BY c.name ASC
        ");
        $stmt->execute([$userId]);
        $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($companies);
    }
    elseif ($_GET["action"] === "add_vehicle") {
        $companyId = $_POST["company_id"] ?? null;
        $title     = $_POST["title"] ?? null;

        if (!$companyId || !$title) {
            echo json_encode([
                "success" => false,
                "error"   => "Firma ve Araç Başlığı zorunludur."
            ]);
            exit;
        }

        $sql = "
            INSERT INTO vehicles 
                (company_id, title, brand, model, year, price, price_currency, is_for_rent, is_for_sale, status, plate, is_plate_hidden, km, is_km_hidden, location_country_id, location_city_id,location_district_id, location_address, gear_type, fuel_type, engine_size, horse_power, color, body_type, description, rental_type, min_rent_duration, min_rent_duration_unit, max_rent_duration, max_rent_duration_unit, tramers_price, tramers_price_currency, traction, rental_km_limit, over_km_price, over_km_price_currency, heavy_damage_record)
            VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $db->prepare($sql);

        $result = $stmt->execute([
            $companyId,
            $title,
            $_POST['brand'] ?? null,
            $_POST['model'] ?? null,
            $_POST['year'] ?? null,
            $_POST['price'] ?? null,
            $_POST['price_currency'] ?? null,
            isset($_POST['is_for_rent']) ? (int)$_POST['is_for_rent'] : 0,
            isset($_POST['is_for_sale']) ? (int)$_POST['is_for_sale'] : 0,
            $_POST['status'] ?? 'available',
            $_POST['plate'] ?? null,
            isset($_POST['is_plate_hidden']) ? (int)$_POST['is_plate_hidden'] : 0,
            $_POST['km'] ?? null,
            isset($_POST['is_km_hidden']) ? (int)$_POST['is_km_hidden'] : 0,
            $_POST['location_country_id'] ?? null,
            $_POST['location_city_id'] ?? null,
            $_POST['location_district_id'] ?? null,
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
            $_POST['min_rent_duration_unit'] ?? null,
            $_POST['max_rent_duration'] ?? null,
            $_POST['max_rent_duration_unit'] ?? null,
            $_POST['tramers_price'] ?? null,
            $_POST['tramers_price_currency'] ?? null,
            $_POST['traction'] ?? null,
            $_POST['rental_km_limit'] ?? null,
            $_POST['over_km_price'] ?? null,
            $_POST['over_km_price_currency'] ?? null,
            isset($_POST['heavy_damage_record']) ? (int)$_POST['heavy_damage_record'] : 0
        ]);



        if ($result) {
            $lastInsertId = $db->lastInsertId();

            $baseUploadDir = __DIR__ . "/../uploads/vehicles/";
            $uploadDir     = $baseUploadDir . $lastInsertId . "/photo/";

            if (!empty($_FILES["vehicle_images"]) && isset($lastInsertId)) {
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Birden fazla dosya olabilir
                foreach ($_FILES["vehicle_images"]["tmp_name"] as $index => $tmpName) {
                    if ($_FILES["vehicle_images"]["error"][$index] === UPLOAD_ERR_OK) {
                        $originalName = basename($_FILES["vehicle_images"]["name"][$index]);
                        $fileSize     = $_FILES["vehicle_images"]["size"][$index];
                        $fileType     = $_FILES["vehicle_images"]["type"][$index];

                        // Dosya adı güvenli hale getir
                        $ext         = pathinfo($originalName, PATHINFO_EXTENSION);
                        $newFileName = uniqid("vehicle_") . "." . $ext;
                        $destination = $uploadDir . $newFileName;

                        if (move_uploaded_file($tmpName, $destination)) {
                            // Dosya başarıyla yüklendi, kayıt ekle
                            $stmtFile = $db->prepare("
                                INSERT INTO files 
                                (file_name, file_path, file_type, file_size, related_table, related_id, created_at)
                                VALUES (?, ?, ?, ?, 'vehicles', ?, NOW())
                            ");
                            $stmtFile->execute([
                                $originalName,
                                "uploads/vehicles/" . $lastInsertId . "/photo/" . $newFileName, // Web den erişilecek yol
                                $fileType,
                                $fileSize,
                                $lastInsertId
                            ]);
                        }
                    }
                }
            }

            $damageJson = $_POST["damage_data"] ?? null;
            if ($damageJson) {
                $damageData = json_decode($damageJson, true);

                if (is_array($damageData)) {
                    // Her parça için değer yoksa original olsun
                    $values = [];
                    foreach ($damageParts as $part) {
                        $values[$part] = $damageData[$part] ?? "original";
                    }

                    $columns      = implode(", ", array_keys($values));
                    $placeholders = implode(", ", array_fill(0, count($values), "?"));

                    $sql = "
                        INSERT INTO vehicles_damage (vehicle_id, $columns, created_at, updated_at)
                        VALUES (?, $placeholders, NOW(), NOW())
                    ";

                    $stmt   = $db->prepare($sql);
                    $params = array_merge([$lastInsertId], array_values($values));
                    $stmt->execute($params);
                }
            }


            echo json_encode([
                "success" => true,
                "id" => $lastInsertId ?? null
            ]);
        }
        else {
            echo json_encode([
                "success" => false,
                "error" => "Veritabanı hatası.",
                "id" => null
            ]);
        }

    }
    elseif ($_GET["action"] === "set_vehicle") {
        $id = $_POST["upd"] ?? null;

        if (!$id || !is_numeric($id)) {
            echo json_encode([
                "success" => false,
                "error"   => "Geçersiz ID"
            ]);
            exit;
        }

        $companyId = $_POST["company_id"] ?? null;
        $title = $_POST["title"] ?? null;

        if (!$companyId || !$title) {
            echo json_encode([
                "success" => false,
                "error"   => "Firma ve Araç Başlığı zorunludur."
            ]);
            exit;
        }

        $sql = "
            UPDATE vehicles SET
                company_id = ?,
                title = ?,
                brand = ?,
                model = ?,
                year = ?,
                price = ?,
                price_currency = ?,
                is_for_rent = ?,
                is_for_sale = ?,
                status = ?,
                plate = ?,
                is_plate_hidden = ?,
                km = ?,
                is_km_hidden = ?,
                location_country_id = ?,
                location_city_id = ?,
                location_district_id = ?,
                location_address = ?,
                gear_type = ?,
                fuel_type = ?,
                engine_size = ?,
                horse_power = ?,
                color = ?,
                body_type = ?,
                description = ?,
                rental_type = ?,
                min_rent_duration = ?,
                min_rent_duration_unit = ?,
                max_rent_duration = ?,
                max_rent_duration_unit = ?,
                tramers_price = ?,
                tramers_price_currency = ?,
                traction = ?,
                rental_km_limit = ?,
                over_km_price = ?,
                over_km_price_currency = ?,
                heavy_damage_record = ?
            WHERE id = ?
        ";

        $stmt   = $db->prepare($sql);
        $result = $stmt->execute([
            $companyId,
            $title,
            $_POST['brand'] ?? null,
            $_POST['model'] ?? null,
            $_POST['year'] ?? null,
            $_POST['price'] ?? null,
            $_POST['price_currency'] ?? null,
            isset($_POST['is_for_rent']) ? (int)$_POST['is_for_rent'] : 0,
            isset($_POST['is_for_sale']) ? (int)$_POST['is_for_sale'] : 0,
            $_POST['status'] ?? 'available',
            $_POST['plate'] ?? null,
            isset($_POST['is_plate_hidden']) ? (int)$_POST['is_plate_hidden'] : 0,
            $_POST['km'] ?? null,
            isset($_POST['is_km_hidden']) ? (int)$_POST['is_km_hidden'] : 0,
            $_POST['location_country_id'] ?? null,
            $_POST['location_city_id'] ?? null,
            $_POST['location_district_id'] ?? null,
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
            $_POST['min_rent_duration_unit'] ?? null,
            $_POST['max_rent_duration'] ?? null,
            $_POST['max_rent_duration_unit'] ?? null,
            $_POST['tramers_price'] ?? null,
            $_POST['tramers_price_currency'] ?? null,
            $_POST['traction'] ?? null,
            $_POST['rental_km_limit'] ?? null,
            $_POST['over_km_price'] ?? null,
            $_POST['over_km_price_currency'] ?? null,
            isset($_POST['heavy_damage_record']) ? (int)$_POST['heavy_damage_record'] : 0,
            $id
        ]);

        if ($result) {

            $baseUploadDir = __DIR__ . "/../uploads/vehicles/";
            $uploadDir     = $baseUploadDir . $id . "/photo/";

            // Yeni yüklenen görselleri kaydet
            if (!empty($_FILES["vehicle_images"]) && is_array($_FILES["vehicle_images"]["tmp_name"])) {
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                foreach ($_FILES["vehicle_images"]["tmp_name"] as $index => $tmpName) {
                    if ($_FILES["vehicle_images"]["error"][$index] === UPLOAD_ERR_OK) {
                        $originalName = basename($_FILES["vehicle_images"]["name"][$index]);
                        $fileSize     = $_FILES["vehicle_images"]["size"][$index];
                        $fileType     = $_FILES["vehicle_images"]["type"][$index];

                        $ext         = pathinfo($originalName, PATHINFO_EXTENSION);
                        $newFileName = uniqid("vehicle_") . "." . $ext;
                        $destination = $uploadDir . $newFileName;

                        if (move_uploaded_file($tmpName, $destination)) {
                            $stmtFile = $db->prepare("
                                INSERT INTO files 
                                (file_name, file_path, file_type, file_size, related_table, related_id, created_at)
                                VALUES (?, ?, ?, ?, 'vehicles', ?, NOW())
                            ");
                            $webPath = "uploads/vehicles/" . $id . "/photo/" . $newFileName;
                            $stmtFile->execute([
                                $originalName,
                                $webPath,
                                $fileType,
                                $fileSize,
                                $id
                            ]);
                        }
                    }
                }
            }

            // Silme işlemi
            if (!empty($_POST["deleted_images"])) {
                $deletedIds = array_filter(explode(",", $_POST["deleted_images"]), function($v) { return is_numeric($v); });

                if (!empty($deletedIds)) {
                    $placeholders = implode(",", array_fill(0, count($deletedIds), "?"));

                    // Dosya yollarını al
                    $stmtSelect = $db->prepare("SELECT file_path FROM files WHERE id IN ($placeholders) AND related_table='vehicles' AND related_id = ?");
                    $stmtSelect->execute(array_merge($deletedIds, [$id]));

                    $filesToDelete = $stmtSelect->fetchAll(PDO::FETCH_COLUMN);

                    // Sunucudan sil
                    foreach ($filesToDelete as $filePath) {
                        $fullPath = __DIR__ . "/../" . $filePath;
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                    }

                    // DB den sil
                    $stmtDelete = $db->prepare("DELETE FROM files WHERE id IN ($placeholders) AND related_table='vehicles' AND related_id = ?");
                    $stmtDelete->execute(array_merge($deletedIds, [$id]));
                }
            }

            $damageJson = $_POST["damage_data"] ?? null;
            if ($damageJson) {
                $damageData = json_decode($damageJson, true);

                if (is_array($damageData)) {
                    // Varsayılan değeri ayarla
                    $values = [];
                    foreach ($damageParts as $part) {
                        $values[$part] = $damageData[$part] ?? "original";
                    }

                    $setParts = [];
                    foreach ($values as $col => $val) {
                        $setParts[] = "`$col` = ?";
                    }

                    $sql = "
                        UPDATE vehicles_damage 
                        SET " . implode(", ", $setParts) . ", updated_at = NOW()
                        WHERE vehicle_id = ?
                    ";

                    $stmt = $db->prepare($sql);

                    $params   = array_values($values);
                    $params[] = $id;  // $id burada güncellenen araç ID si olmalı

                    $stmt->execute($params);

                    // Eğer hiç satır güncellenmediyse ekle
                    if ($stmt->rowCount() === 0) {
                        $columns      = implode(", ", array_keys($values));
                        $placeholders = implode(", ", array_fill(0, count($values), "?"));

                        $insertSql = "
                            INSERT INTO vehicles_damage (vehicle_id, $columns, created_at, updated_at)
                            VALUES (?, $placeholders, NOW(), NOW())
                        ";

                        $insertStmt   = $db->prepare($insertSql);
                        $insertParams = array_merge([$id], array_values($values));
                        $insertStmt->execute($insertParams);
                    }
                }
            }

            echo json_encode([
                "success" => true,
                "id"      => $id ?? null // veya $inserted_id ya da $_POST["id"]
            ]);
        }
        else {
            echo json_encode([
                "success" => false,
                "id"      => $id ?? null, // hata olsa da id yi döndür
                "error"   => "Güncelleme sırasında veritabanı hatası."
            ]);
        }

    }
    elseif ($_GET["action"] === "getCountries") {
        $stmt = $db->query("SELECT id, name FROM countries ORDER BY name ASC");
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row["id"] . '">' . htmlspecialchars($row["name"]) . '</option>';
        }
    }
    elseif ($_GET["action"] === "getCities" && isset($_POST["country_id"])) {
        $countryId = (int)$_POST["country_id"];
        $stmt = $db->prepare("SELECT id, name FROM cities WHERE country_id = ? ORDER BY name ASC");
        $stmt->execute([$countryId]);
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row["id"] . '">' . htmlspecialchars($row["name"]) . '</option>';
        }
    }
    elseif ($_GET["action"] === "getDistricts" && isset($_POST["city_id"])) {
        $cityId = (int)$_POST["city_id"];
        $stmt = $db->prepare("SELECT id, name FROM districts WHERE city_id = ? ORDER BY name ASC");
        $stmt->execute([$cityId]);
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row["id"] . '">' . htmlspecialchars($row["name"]) . '</option>';
        }
    }
    elseif ($_GET["action"] === "get_vehicles") {

        $columns = [
            'id', 'title', 'brand', 'model', 'year', 'price', 'price_currency',
            'is_for_rent', 'is_for_sale', 'status', 'created_at', 'plate',
            'is_plate_hidden', 'km', 'is_km_hidden', 'location_address',
            'location_country_id', 'location_city_id', 'location_district_id',
            'gear_type', 'fuel_type', 'engine_size', 'horse_power', 'color',
            'body_type', 'description', 'rental_type',
            'min_rent_duration', 'min_rent_duration_unit',
            'max_rent_duration', 'max_rent_duration_unit',
            'tramers_price', 'tramers_price_currency',
            'traction', 'rental_km_limit',
            'over_km_price', 'over_km_price_currency',
            'heavy_damage_record'
        ];


        $draw = intval($_POST['draw'] ?? 1);
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);
        if ($length === -1) {
            $length = 1000000;
        }
        $searchValue = $_POST['search']['value'] ?? '';

        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDir = $_POST['order'][0]['dir'] ?? 'desc';
        $orderDir = strtolower($orderDir) === 'asc' ? 'ASC' : 'DESC';

        $totalRecords = $db->query("SELECT COUNT(*) FROM vehicles WHERE company_id = {$_SESSION["selected_company_id"]}")->fetchColumn();

        $searchSql = "WHERE v.company_id = :company_id ";
        $searchParams = [":company_id" => $_SESSION["selected_company_id"]];

        if ($searchValue !== '') {
            $searchSqlParts = [];
            foreach ($columns as $index => $col) {
                $paramName = ":search_$index";
                $searchSqlParts[] = "v.$col LIKE $paramName";
                $searchParams[$paramName] = "%$searchValue%";
            }
            $searchSql .= "AND (" . implode(" OR ", $searchSqlParts) . ") ";
        }

        if (!empty($_POST['filters']) && is_array($_POST['filters'])) {
            foreach ($_POST['filters'] as $field => $value) {
                if ($value === '' || $value === null) continue;

                if (str_ends_with($field, '_min')) {
                    $col = substr($field, 0, -4);
                    if (in_array($col, $columns)) {
                        $paramName = ":{$col}_min";
                        $searchSql .= "AND v.`$col` >= $paramName ";
                        $searchParams[$paramName] = $value;
                    }
                } elseif (str_ends_with($field, '_max')) {
                    $col = substr($field, 0, -4);
                    if (in_array($col, $columns)) {
                        $paramName = ":{$col}_max";
                        $searchSql .= "AND v.`$col` <= $paramName ";
                        $searchParams[$paramName] = $value;
                    }
                } elseif (in_array($field, $columns)) {
                    $paramName = ":$field";
                    if (is_numeric($value)) {
                        $searchSql .= "AND v.`$field` = $paramName ";
                        $searchParams[$paramName] = $value;
                    } else {
                        $searchSql .= "AND v.`$field` LIKE $paramName ";
                        $searchParams[$paramName] = '%' . $value . '%';
                    }
                }
            }
        }

        $stmt = $db->prepare("SELECT COUNT(*) FROM vehicles v $searchSql");
        $stmt->execute($searchParams);
        $filteredRecords = $stmt->fetchColumn();

        $start = (int)$start;
        $length = (int)$length;

        $sql = "
            SELECT 
                v.*, 
                c.name AS location_country_name,
                ci.name AS location_city_name,
                d.name AS location_district_name
            FROM vehicles v
            LEFT JOIN countries c ON v.location_country_id = c.id
            LEFT JOIN cities ci ON v.location_city_id = ci.id
            LEFT JOIN districts d ON v.location_district_id = d.id
            $searchSql
            ORDER BY v.$orderColumn $orderDir
            LIMIT $start, $length
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($searchParams);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $trEnums = [
            "gear_type" => [
                "manual"         => "Manuel",
                "automatic"      => "Otomatik",
                "semi-automatic" => "Yarı Otomatik"
            ],
            "fuel_type" => [
                "petrol"   => "Benzin",
                "diesel"   => "Dizel",
                "lpg"      => "LPG",
                "electric" => "Elektrik",
                "hybrid"   => "Hibrit"
            ],
            "body_type" => [
                "sedan"       => "Sedan",
                "hatchback"   => "Hatchback",
                "suv"         => "SUV",
                "pickup"      => "Pickup",
                "coupe"       => "Coupe",
                "convertible" => "Cabrio",
                "van"         => "Van",
                "other"       => "Diğer"
            ],
            "rental_type" => [
                "daily"   => "Günlük",
                "weekly"  => "Haftalık",
                "monthly" => "Aylık",
                "none"    => "Yok"
            ],
            "status" => [
                "available" => "Mevcut",
                "reserved"  => "Rezerve",
                "sold"      => "Satıldı",
                "rented"    => "Kirada"
            ]
        ];


        foreach ($data as &$row) {
            foreach (["price", "tramers_price", "over_km_price"] as $priceField) {
                if (isset($row[$priceField])) {
                    $currencyField = $priceField . "_currency";
                    $currencySymbol = getCurrencySymbol($row[$currencyField]) ?? "₺";
                    $row[$priceField] = number_format($row[$priceField], 2, ",", ".") . " " . $currencySymbol;
                }
            }

            if (isset($row["created_at"])) {
                $row["created_at"] = date("d/m/Y H:i:s", strtotime($row["created_at"]));
            }

            foreach ($trEnums as $field => $map) {
                if (isset($row[$field]) && isset($map[$row[$field]])) {
                    $row[$field] = $map[$row[$field]];
                }
            }

            foreach (["min_rent_duration", "max_rent_duration"] as $durationField) {
                $unitField = $durationField . "_unit";
                if (isset($row[$durationField])) {
                    $unit = getDurationUnitLabel($row[$unitField]) ?? 'Gün';
                    $row[$durationField] .= ' ' . $unit;
                }
            }

            if (isset($row["traction"])) {
                $row["traction"] = strtoupper($row["traction"]);
            }

            if (isset($row["color"])) {
                $colorHex = strtoupper($row["color"]);

                if (isset($predefinedColors[$colorHex])) {
                    // Ön tanımlı renkse: isim + renk kutusu
                    $colorLabel = $predefinedColors[$colorHex];
                } else {
                    // Diğer renk: hex kodunu koru
                    $colorLabel = "Diğer";
                }

                $row["color"] = '
                    <span 
                        style="display:inline-block;width:16px;height:16px;background-color:' . $colorHex . ';border:1px solid #ccc;margin-right:6px;cursor:pointer;" 
                        onclick="
                            toastr.options = {
                                timeOut: 0,
                                extendedTimeOut: 0,
                                closeButton: true
                            };
                            navigator.clipboard.writeText(\'' . $colorHex . '\').then(() => {
                                toastr.success(\'Renk kodu kopyalandı: ' . $colorHex . '\');
                            });
                        "
                        title="Renk kodunu kopyala"
                    ></span> ' . $colorLabel;


            }

        }
        unset($row);

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data" => $data
        ]);
    }
    elseif ($_GET["action"] === "save_columns") {
        $selectedColumns = $_POST["columns"] ?? [];
        $tableName = $_POST["table_name"] ?? [];

        $userId = $_SESSION["user_id"] ?? null;

        if ($userId && is_array($selectedColumns)) {
            // Önce eski tercihleri sil
            $deleteQuery = $db->prepare("DELETE FROM user_column_preferences WHERE user_id = ? AND table_name = ?");
            $deleteQuery->execute([$userId, $tableName]);

            // Yeni tercihleri kaydet
            $insertQuery = $db->prepare("INSERT INTO user_column_preferences (user_id, table_name, column_name) VALUES (?, ?, ?)");
            foreach ($selectedColumns as $column) {
                $insertQuery->execute([$userId, $tableName, $column]);
            }

            echo json_encode([
                "success" => true,
                "message" => "Sütun tercihleri kaydedildi."
            ]);
        }
        else {
            echo json_encode([
                "success" => false,
                "message" => "Geçersiz veri."
            ]);
        }
    }
    elseif ($_GET["action"] === "get_customers") {

        $columns = [
            'id', 'first_name', 'second_name', 'last_name', 'phone_number', 'email', 'national_id', 'tax_id',
            'location_address', 'location_country_id', 'location_city_id', 'location_district_id',
            'note', 'is_active', 'notification_enabled', 'created_at', 'updated_at'
        ];


        $draw = intval($_POST['draw'] ?? 1);
        $start = intval($_POST['start'] ?? 0);
        $length = intval($_POST['length'] ?? 10);
        if ($length === -1) {
            $length = 1000000;
        }
        $searchValue = $_POST['search']['value'] ?? '';

        $orderColumnIndex = $_POST['order'][0]['column'] ?? 0;
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDir = $_POST['order'][0]['dir'] ?? 'desc';
        $orderDir = strtolower($orderDir) === 'asc' ? 'ASC' : 'DESC';

        $totalRecords = $db->query("SELECT COUNT(*) FROM customers WHERE company_id = {$_SESSION["selected_company_id"]}")->fetchColumn();

        $searchSql = "WHERE v.company_id = :company_id ";
        $searchParams = [":company_id" => $_SESSION["selected_company_id"]];

        if ($searchValue !== '') {
            $searchSqlParts = [];
            foreach ($columns as $index => $col) {
                $paramName = ":search_$index";
                $searchSqlParts[] = "v.$col LIKE $paramName";
                $searchParams[$paramName] = "%$searchValue%";
            }
            $searchSql .= "AND (" . implode(" OR ", $searchSqlParts) . ") ";
        }

        if (!empty($_POST['filters']) && is_array($_POST['filters'])) {
            foreach ($_POST['filters'] as $field => $value) {
                if ($value === '' || $value === null) continue;

                if (in_array($field, $columns)) {
                    $paramName = ":$field";
                    if (is_numeric($value)) {
                        $searchSql .= "AND v.`$field` = $paramName ";
                        $searchParams[$paramName] = $value;
                    }
                    else {
                        $searchSql .= "AND v.`$field` LIKE $paramName ";
                        $searchParams[$paramName] = '%' . $value . '%';
                    }
                }
            }
        }

        //echo "<pre>"; print_r($searchParams);
        $stmt = $db->prepare("SELECT COUNT(*) FROM customers v $searchSql");
        $stmt->execute($searchParams);
        $filteredRecords = $stmt->fetchColumn();

        $start = (int)$start;
        $length = (int)$length;

        $sql = "
            SELECT 
                v.*, 
                c.name AS location_country_name,
                ci.name AS location_city_name,
                d.name AS location_district_name
            FROM customers v
            LEFT JOIN countries c ON v.location_country_id = c.id
            LEFT JOIN cities ci ON v.location_city_id = ci.id
            LEFT JOIN districts d ON v.location_district_id = d.id
            $searchSql
            ORDER BY v.$orderColumn $orderDir
            LIMIT $start, $length
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($searchParams);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as &$row) {
            if (isset($row["created_at"])) {
                $row["created_at"] = date("d/m/Y H:i:s", strtotime($row["created_at"]));
            }
            if (isset($row["updated_at"])) {
                $row["updated_at"] = date("d/m/Y H:i:s", strtotime($row["updated_at"]));
            }
        }
        unset($row);

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data" => $data
        ]);
    }
    else {
            echo json_encode([
                "success" => false,
                "error"   => "Geçersiz istek"
            ]);
        }
}
else {
    echo json_encode([
        "success" => false,
        "error"   => "Action parametresi eksik"
    ]);
}

exit;
