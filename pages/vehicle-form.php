<?php

$page_text = "Ekleme";
if(isset($_GET["id"]) && intval($_GET["id"]) > 0) {
    $page_text = "Güncelleme";
}

$current_page = "vehicles";
$page_title = "Araç ". $page_text;
$breadcrumb_home = "Araçlar";
$breadcrumb_home_link = "pages/vehicles";
?>

<?php require_once '../includes/init.php'; ?>
<?php include("../includes/header.php"); ?>

<style>
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #fff !important;
        color: #000 !important;
    }

    #color-picker:disabled {
        opacity: 0.5;
        cursor: not-allowed; /* no-drop yerine */
    }

    #color-picker {
        height: calc(2.375rem + 1px);
        padding: 0.375rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        background-color: #fff;
    }

</style>

<?php
$edit_data = [];
$edit_inp = "";
$ajax_url = "add_vehicle";
if(isset($_GET["id"]) && intval($_GET["id"]) > 0) {
    $id = intval($_GET["id"]);
    $ajax_url = "set_vehicle";
    $edit_inp = "<input type='hidden' name='upd' value='".$id."'>";
    $edit_data = $db->query("SELECT * FROM vehicles WHERE id = ".$id)->fetch(PDO::FETCH_ASSOC);

    // Düzenleme modunda, örneğin araç ID'si $vehicleId ise
    $stmt = $db->prepare("SELECT id, file_path FROM files WHERE related_table = 'vehicles' AND related_id = ?");
    $stmt->execute([$id]);
    $existingImages = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

?>


<div class="app-content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card card-info card-outline mb-4 p-1">
                    <div class="card-header"><div class="card-title">Araç Ekleme Formu</div></div>

                    <form id="vehicleForm" class="needs-validation" novalidate>
                        <?=$edit_inp?>
                        <div class="card-body">
                            <div class="row g-3">
                                <?php /*=print_c($_SESSION);*/?>
                                <!-- Firma ve Genel Bilgiler -->
                                <h3 class="mb-3">Genel Bilgiler</h3>

                                <div class="col-md-6">
                                    <label for="company_id" class="form-label">Firma</label>
                                    <select id="company_id" name="company_id" class="form-select" required>
                                        <option value="" disabled selected>Firma seçiniz</option>
                                        <?php
                                        $companies = $db->query("SELECT id, name FROM companies ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($companies as $company) {
                                            $selected = ($_SESSION["selected_company_id"] == $company["id"]) ? "selected" : "disabled";
                                            echo '<option value="'.$company['id'].'" '.$selected.'>'.htmlspecialchars($company['name']).'</option>';
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Firma seçimi zorunludur.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="title" class="form-label">Araç Başlığı</label>
                                    <input type="text" id="title" name="title" class="form-control" value="<?= $edit_data["title"] ?? "" ?>" required>
                                    <div class="invalid-feedback">Araç başlığı zorunludur.</div>
                                </div>

                                <hr class="my-4" />

                                <!-- Araç Teknik Bilgileri -->
                                <h3 class="mb-3">Araç Teknik Bilgileri</h3>

                                <div class="col-md-4">
                                    <label for="brand" class="form-label">Marka <span style="color: red">(*)</span></label>
                                    <input type="text" id="brand" name="brand" class="form-control" value="<?= $edit_data["brand"] ?? "" ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="model" class="form-label">Model <span style="color: red">(*)</span></label>
                                    <input type="text" id="model" name="model" class="form-control" value="<?= $edit_data["model"] ?? "" ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="form-label">Yıl <span style="color: red">(*)</span></label>
                                    <input type="number" id="year" name="year" class="form-control" min="1900" max="<?php echo date('Y')+1; ?>"  value="<?= $edit_data["year"] ?? "" ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="traction" class="form-label">Çekiş Tipi</label>
                                    <select id="traction" name="traction" class="form-select">
                                        <option value="" <?= ($edit_data["traction"] ?? '') == "" ? "selected" : "" ?>>Seçiniz</option>
                                        <option value="fwd" <?= ($edit_data["traction"] ?? '') == "fwd" ? "selected" : "" ?>>Önden Çekiş (FWD)</option>
                                        <option value="rwd" <?= ($edit_data["traction"] ?? '') == "rwd" ? "selected" : "" ?>>Arkadan İtiş (RWD)</option>
                                        <option value="awd" <?= ($edit_data["traction"] ?? '') == "awd" ? "selected" : "" ?>>4 Tekerlekten Çekiş (AWD)</option>
                                        <option value="4wd" <?= ($edit_data["traction"] ?? '') == "4wd" ? "selected" : "" ?>>4x4 (4WD)</option>
                                        <option value="other" <?= ($edit_data["traction"] ?? '') == "other" ? "selected" : "" ?>>Diğer</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="color" class="form-label">Renk <small style="color:red;">(Ana renk seçin veya özel renk için "Diğer..." seçeneğini kullanın)</small></label>

                                    <div class="input-group">
                                        <input type="color" id="color-picker" value="<?= htmlspecialchars($edit_data["color"] ?? '#ffffff') ?>" disabled>
                                        <select id="color-select" class="form-select mb-2" aria-label="Ana renk seçimi" >
                                            <?php foreach ($predefinedColors as $hex => $label): ?>
                                                <option value="<?= $hex ?>" <?= ($edit_data["color"] ?? '') == $hex ? 'selected' : '' ?>>
                                                    <?= $label ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="custom" <?= (!isset($predefinedColors[$edit_data["color"] ?? ''])) ? 'selected' : '' ?>>Diğer...</option>
                                        </select>
                                        <input type="hidden" name="color" id="color-hidden">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="body_type" class="form-label">Kasa Tipi</label>
                                    <select id="body_type" name="body_type" class="form-select">
                                        <option value="" <?= ($edit_data["body_type"] ?? '') == "" ? "selected" : "" ?>>Seçiniz</option>
                                        <option value="sedan" <?= ($edit_data["body_type"] ?? '') == "sedan" ? "selected" : "" ?>>Sedan</option>
                                        <option value="hatchback" <?= ($edit_data["body_type"] ?? '') == "hatchback" ? "selected" : "" ?>>Hatchback</option>
                                        <option value="suv" <?= ($edit_data["body_type"] ?? '') == "suv" ? "selected" : "" ?>>SUV</option>
                                        <option value="pickup" <?= ($edit_data["body_type"] ?? '') == "pickup" ? "selected" : "" ?>>Pickup</option>
                                        <option value="coupe" <?= ($edit_data["body_type"] ?? '') == "coupe" ? "selected" : "" ?>>Coupe</option>
                                        <option value="convertible" <?= ($edit_data["body_type"] ?? '') == "convertible" ? "selected" : "" ?>>Convertible</option>
                                        <option value="van" <?= ($edit_data["body_type"] ?? '') == "van" ? "selected" : "" ?>>Van</option>
                                        <option value="other" <?= ($edit_data["body_type"] ?? '') == "other" ? "selected" : "" ?>>Diğer</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="gear_type" class="form-label">Vites Tipi</label>
                                    <select id="gear_type" name="gear_type" class="form-select">
                                        <option value="automatic" <?= ($edit_data["gear_type"] ?? '') == "automatic" ? "selected" : "" ?>>Otomatik</option>
                                        <option value="manual" <?= ($edit_data["gear_type"] ?? '') == "manual" ? "selected" : "" ?>>Manuel</option>
                                        <option value="semi-automatic" <?= ($edit_data["gear_type"] ?? '') == "semi-automatic" ? "selected" : "" ?>>Yarı Otomatik</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="fuel_type" class="form-label">Yakıt Türü</label>
                                    <select id="fuel_type" name="fuel_type" class="form-select">
                                        <option value="petrol" <?= ($edit_data["fuel_type"] ?? '') == "petrol" ? "selected" : "" ?>>Benzin</option>
                                        <option value="diesel" <?= ($edit_data["fuel_type"] ?? '') == "diesel" ? "selected" : "" ?>>Dizel</option>
                                        <option value="lpg" <?= ($edit_data["fuel_type"] ?? '') == "lpg" ? "selected" : "" ?>>LPG</option>
                                        <option value="electric" <?= ($edit_data["fuel_type"] ?? '') == "electric" ? "selected" : "" ?>>Elektrikli</option>
                                        <option value="hybrid" <?= ($edit_data["fuel_type"] ?? '') == "hybrid" ? "selected" : "" ?>>Hibrit</option>
                                    </select>
                                </div>


                                <hr class="my-4" />

                                <!-- Durum ve Fiyatlandırma -->
                                <h3 class="mb-3">Durum & Fiyatlandırma</h3>

                                <div class="col-md-12">
                                    <label for="status" class="form-label">Durum</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="available" <?= ($edit_data["status"] ?? '') == "available" ? "selected" : "" ?>>Mevcut</option>
                                        <option value="reserved" <?= ($edit_data["status"] ?? '') == "reserved" ? "selected" : "" ?>>Rezerve</option>
                                        <option value="sold" <?= ($edit_data["status"] ?? '') == "sold" ? "selected" : "" ?>>Satıldı</option>
                                        <option value="rented" <?= ($edit_data["status"] ?? '') == "rented" ? "selected" : "" ?>>Kirada</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Kiralık Mı ?</label>
                                    <select id="is_for_rent" name="is_for_rent" class="form-select">
                                        <option value="0" <?= ($edit_data["is_for_rent"] ?? '') == "0" ? "selected" : "" ?>>Hayır</option>
                                        <option value="1" <?= ($edit_data["is_for_rent"] ?? '') == "1" ? "selected" : "" ?>>Evet</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="rental_type" class="form-label">Kiralama Tipi</label>
                                    <select id="rental_type" name="rental_type" class="form-select">
                                        <option value="none" <?= ($edit_data["rental_type"] ?? '') == "none" ? "selected" : "" ?>>Yok</option>
                                        <option value="daily" <?= ($edit_data["rental_type"] ?? '') == "daily" ? "selected" : "" ?>>Günlük</option>
                                        <option value="weekly" <?= ($edit_data["rental_type"] ?? '') == "weekly" ? "selected" : "" ?>>Haftalık</option>
                                        <option value="monthly" <?= ($edit_data["rental_type"] ?? '') == "monthly" ? "selected" : "" ?>>Aylık</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="min_rent_duration" class="form-label">Minimum Kiralama Süresi</label>
                                    <div class="input-group">
                                        <input type="number" id="min_rent_duration" name="min_rent_duration" class="form-control" min="0" value="<?= $edit_data["min_rent_duration"] ?? "" ?>">
                                        <select name="min_rent_duration_unit" class="form-select" style="max-width: 80px;">
                                            <option value="gun" <?= ($edit_data["min_rent_duration_unit"] ?? '') === 'gun' ? 'selected' : '' ?>>Gün</option>
                                            <option value="ay" <?= ($edit_data["min_rent_duration_unit"] ?? '') === 'ay' ? 'selected' : '' ?>>Ay</option>
                                            <option value="yil" <?= ($edit_data["min_rent_duration_unit"] ?? '') === 'yil' ? 'selected' : '' ?>>Yıl</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for="max_rent_duration" class="form-label">Maksimum Kiralama Süresi</label>
                                    <div class="input-group">
                                        <input type="number" id="max_rent_duration" name="max_rent_duration" class="form-control" min="0" value="<?= $edit_data["max_rent_duration"] ?? "" ?>">
                                        <select name="max_rent_duration_unit" class="form-select" style="max-width: 80px;">
                                            <option value="gun" <?= ($edit_data["max_rent_duration_unit"] ?? '') === 'gun' ? 'selected' : '' ?>>Gün</option>
                                            <option value="ay" <?= ($edit_data["max_rent_duration_unit"] ?? '') === 'ay' ? 'selected' : '' ?>>Ay</option>
                                            <option value="yil" <?= ($edit_data["max_rent_duration_unit"] ?? '') === 'yil' ? 'selected' : '' ?>>Yıl</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for="rental_km_limit" class="form-label">Kiralama Km Limiti (km)</label>
                                    <input type="number" id="rental_km_limit" name="rental_km_limit" class="form-control" min="0" value="<?= $edit_data["rental_km_limit"] ?? "" ?>">
                                </div>

                                <div class="col-md-2">
                                    <label for="over_km_price" class="form-label">Km Aşım Ücreti (fiyat/km)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" id="over_km_price" name="over_km_price" class="form-control" min="0" value="<?= $edit_data["over_km_price"] ?? "" ?>">
                                        <select name="over_km_price_currency" class="form-select" style="max-width: 80px;">
                                            <option value="TRY" <?= ($edit_data["over_km_price_currency"] ?? '') === 'TRY' ? 'selected' : '' ?>>₺</option>
                                            <option value="USD" <?= ($edit_data["over_km_price_currency"] ?? '') === 'USD' ? 'selected' : '' ?>>$</option>
                                            <option value="EUR" <?= ($edit_data["over_km_price_currency"] ?? '') === 'EUR' ? 'selected' : '' ?>>€</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Satılık Mı ?</label>
                                    <select id="is_for_sale" name="is_for_sale" class="form-select">
                                        <option value="0" <?= ($edit_data["is_for_sale"] ?? '') == "0" ? "selected" : "" ?>>Hayır</option>
                                        <option value="1" <?= ($edit_data["is_for_sale"] ?? '') == "1" ? "selected" : "" ?>>Evet</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="price" class="form-label">Fiyat</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" id="price" name="price" class="form-control" min="0" value="<?= $edit_data["price"] ?? "" ?>">
                                        <select name="price_currency" class="form-select" style="max-width: 80px;">
                                            <option value="TRY" <?= ($edit_data["price_currency"] ?? '') === 'TRY' ? 'selected' : '' ?>>₺</option>
                                            <option value="USD" <?= ($edit_data["price_currency"] ?? '') === 'USD' ? 'selected' : '' ?>>$</option>
                                            <option value="EUR" <?= ($edit_data["price_currency"] ?? '') === 'EUR' ? 'selected' : '' ?>>€</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="my-4" />

                                <!-- Plaka & Kilometre -->
                                <h3 class="mb-3">Plaka & Kilometre</h3>

                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <label for="plate" class="form-label mb-0">Plaka</label>
                                        <input type="text" id="plate" name="plate" class="form-control" value="<?= $edit_data["plate"] ?? "" ?>">
                                    </div>

                                    <div class="form-check form-switch" style="white-space: nowrap;">
                                        <input class="form-check-input" type="checkbox" id="is_plate_hidden" name="is_plate_hidden" value="1" <?= !empty($edit_data["is_plate_hidden"]) ? 'checked' : '' ?> />
                                        <label class="form-check-label" for="is_plate_hidden" style="font-size: 0.85rem;">Gizli</label>
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <label for="km" class="form-label mb-0">Kilometre</label>
                                        <input type="number" id="km" name="km" class="form-control" min="0" value="<?= $edit_data["km"] ?? "" ?>">
                                    </div>

                                    <div class="form-check form-switch" style="white-space: nowrap;">
                                        <input class="form-check-input" type="checkbox" id="is_km_hidden" name="is_km_hidden" value="1" <?= !empty($edit_data["is_km_hidden"]) ? 'checked' : '' ?> />
                                        <label class="form-check-label" for="is_km_hidden" style="font-size: 0.85rem;">Gizli</label>
                                    </div>
                                </div>

                                <hr class="my-4" />

                                <!-- Konum Bilgileri -->
                                <h3 class="mb-3">Konum Bilgileri</h3>

                                <div class="col-md-4">
                                    <label for="location_country_id" class="form-label">Ülke</label>
                                    <select id="location_country_id" name="location_country_id" class="form-select select2"
                                            data-selected-country="<?= $edit_data['location_country_id'] ?? '' ?>"
                                            data-selected-city="<?= $edit_data['location_city_id'] ?? '' ?>"
                                            data-selected-district="<?= $edit_data['location_district_id'] ?? '' ?>"
                                            required>
                                        <option value="">Ülke Seçin</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="location_city_id" class="form-label">İl</label>
                                    <select id="location_city_id" name="location_city_id" class="form-control select2" style="width: 100%;" placeholder="Ara.." disabled>
                                        <option value="">İl Seçin</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="location_district_id" class="form-label">İlçe</label>
                                    <select id="location_district_id" name="location_district_id" class="form-control select2" style="width: 100%;" placeholder="Ara.." disabled>
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="location_address" class="form-label">Adres</label>
                                    <input type="text" id="location_address" name="location_address" class="form-control" value="<?=$edit_data["location_address"] ?? "" ?>">
                                </div>

                                <hr class="my-4" />

                                <!-- Diğer Teknik Detaylar -->
                                <h3 class="mb-3">Diğer Teknik Detaylar</h3>

                                <div class="col-md-3">
                                    <label for="engine_size" class="form-label">Motor Hacmi (Litre)</label>
                                    <input type="number" step="0.01" id="engine_size" name="engine_size" class="form-control" min="0" max="10" value="<?= $edit_data["engine_size"] ?? "" ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="horse_power" class="form-label">Motor Gücü (HP)</label>
                                    <input type="number" id="horse_power" name="horse_power" class="form-control" min="0" value="<?= $edit_data["horse_power"] ?? "" ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="tramers_price" class="form-label">Tramer Fiyatı</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" id="tramers_price" name="tramers_price" class="form-control" min="0" value="<?= $edit_data["tramers_price"] ?? "" ?>">
                                        <select name="tramers_price_currency" class="form-select" style="max-width: 80px;">
                                            <option value="TRY" <?= ($edit_data["tramers_price_currency"] ?? '') === 'TRY' ? 'selected' : '' ?>>₺</option>
                                            <option value="USD" <?= ($edit_data["tramers_price_currency"] ?? '') === 'USD' ? 'selected' : '' ?>>$</option>
                                            <option value="EUR" <?= ($edit_data["tramers_price_currency"] ?? '') === 'EUR' ? 'selected' : '' ?>>€</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label">Ağır Hasar Kaydı</label>
                                    <select id="heavy_damage_record" name="heavy_damage_record" class="form-select">
                                        <option value="0" <?= ($edit_data["heavy_damage_record"] ?? '') == "0" ? "selected" : "" ?>>Yok</option>
                                        <option value="1" <?= ($edit_data["heavy_damage_record"] ?? '') == "1" ? "selected" : "" ?>>Var</option>
                                    </select>
                                </div>

                                <hr class="my-4" />

                                <div class="container">
                                    <div class="row align-items-start">
                                        <div class="col-md-6">
                                            <!-- Araç Açıklaması -->
                                            <h3 class="mb-3">Araç Açıklaması</h3>
                                            <textarea id="description" name="description" class="form-control" rows="6"><?= htmlspecialchars($edit_data["description"] ?? "") ?></textarea>
                                        </div>

                                        <!-- Dikey Çizgi -->
                                        <div class="col-md-1 d-flex justify-content-center">
                                            <div style="border-left:1px solid #ddd; height:100%; min-height:250px;"></div>
                                        </div>

                                        <div class="col-md-5">
                                            <!-- Araç Görselleri -->
                                            <h3 class="mb-3">Araç Görselleri</h3>
                                            <div id="drop-area"
                                                 class="border border-primary rounded p-3 text-center"
                                                 style="min-height: 150px; cursor: pointer;"
                                                 onclick="$('#vehicle_images').click()">
                                                <p class="text-muted mb-0">Görselleri buraya sürükleyin ya da tıklayıp seçin</p>
                                            </div>
                                            <div class="form-text mb-3">
                                                Yalnızca JPG veya PNG formatı. Maksimum 5MB. En az 1 görsel zorunludur.
                                            </div>

                                            <div id="preview" class="d-flex flex-wrap"></div>

                                            <input type="file" id="vehicle_images" name="vehicle_images[]" accept=".jpg,.jpeg,.png" multiple class="d-none">
                                            <input type="hidden" name="deleted_images" id="deleted_images" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-info">Araç <?=$page_text?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Görsel Önizleme Modalı -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- büyük modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">Görsel Önizleme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body text-center position-relative">
                <img src="" id="imagePreviewModalImg" style="max-width: 100%; height: auto;" alt="Önizleme">

                <button type="button" class="btn btn-secondary position-absolute top-50 start-0 translate-middle-y" id="prevImageBtn" style="z-index: 1055;">&#8592;</button>
                <button type="button" class="btn btn-secondary position-absolute top-50 end-0 translate-middle-y" id="nextImageBtn" style="z-index: 1055;">&#8594;</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= BASE_URL ?>assets/ckeditor4-4.22.1/ckeditor.js"></script>

<!-- Select2 CSS ve JS (AdminLTE ile uyumlu) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
    var ajax_url = "<?=$ajax_url?>";
    var existingImagesPHP = <?= json_encode($existingImages, JSON_UNESCAPED_UNICODE) ?>;
</script>

<script src="<?= BASE_URL ?>assets/vehicle-form.js"></script>

<?php include("../includes/footer.php"); ?>
