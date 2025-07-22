<?php require_once '../includes/init.php'; ?>
<?php include("../includes/header.php"); ?>
<style>
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #fff !important;
        color: #000 !important;
    }
</style>


<div class="app-content">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card card-info card-outline mb-4 p-1">
                    <div class="card-header"><div class="card-title">Araç Ekleme Formu</div></div>

                    <form id="vehicleForm" class="needs-validation" novalidate>
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
                                    <input type="text" id="title" name="title" class="form-control" required>
                                    <div class="invalid-feedback">Araç başlığı zorunludur.</div>
                                </div>

                                <hr class="my-4" />

                                <!-- Araç Teknik Bilgileri -->
                                <h3 class="mb-3">Araç Teknik Bilgileri</h3>

                                <div class="col-md-4">
                                    <label for="brand" class="form-label">Marka <span style="color: red">(*)</span></label>
                                    <input type="text" id="brand" name="brand" class="form-control" >
                                </div>

                                <div class="col-md-4">
                                    <label for="model" class="form-label">Model <span style="color: red">(*)</span></label>
                                    <input type="text" id="model" name="model" class="form-control" >
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="form-label">Yıl <span style="color: red">(*)</span></label>
                                    <input type="number" id="year" name="year" class="form-control" min="1900" max="<?php echo date('Y')+1; ?>" >
                                </div>

                                <div class="col-md-4">
                                    <label for="traction" class="form-label">Çekiş Tipi</label>
                                    <select id="traction" name="traction" class="form-select">
                                        <option value="" selected>Seçiniz</option>
                                        <option value="fwd">Önden Çekiş (FWD)</option>
                                        <option value="rwd">Arkadan İtiş (RWD)</option>
                                        <option value="awd">4 Tekerlekten Çekiş (AWD)</option>
                                        <option value="4wd">4x4 (4WD)</option>
                                        <option value="other">Diğer</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="color" class="form-label">Renk<span style="color: red">bura renk seçimi olacak</span></label>
                                    <input type="text" id="color" name="color" class="form-control" maxlength="30">
                                </div>

                                <div class="col-md-4">
                                    <label for="body_type" class="form-label">Kasa Tipi</label>
                                    <select id="body_type" name="body_type" class="form-select">
                                        <option value="" selected>Seçiniz</option>
                                        <option value="sedan">Sedan</option>
                                        <option value="hatchback">Hatchback</option>
                                        <option value="suv">SUV</option>
                                        <option value="pickup">Pickup</option>
                                        <option value="coupe">Coupe</option>
                                        <option value="convertible">Convertible</option>
                                        <option value="van">Van</option>
                                        <option value="other">Diğer</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="gear_type" class="form-label">Vites Tipi</label>
                                    <select id="gear_type" name="gear_type" class="form-select">
                                        <option value="automatic" selected>Otomatik</option>
                                        <option value="manual">Manuel</option>
                                        <option value="semi-automatic">Yarı Otomatik</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="fuel_type" class="form-label">Yakıt Türü</label>
                                    <select id="fuel_type" name="fuel_type" class="form-select">
                                        <option value="petrol" selected>Benzin</option>
                                        <option value="diesel">Dizel</option>
                                        <option value="lpg">LPG</option>
                                        <option value="electric">Elektrikli</option>
                                        <option value="hybrid">Hibrit</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <p>görsel yükleme</p>
                                </div>

                                <hr class="my-4" />

                                <!-- Durum ve Fiyatlandırma -->
                                <h3 class="mb-3">Durum & Fiyatlandırma</h3>

                                <div class="col-md-12">
                                    <label for="status" class="form-label">Durum</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="available" selected>Mevcut</option>
                                        <option value="reserved">Rezerve</option>
                                        <option value="sold">Satıldı</option>
                                        <option value="rented">Kirada</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Kiralık Mı ?</label>
                                    <select id="is_for_rent" name="is_for_rent" class="form-select">
                                        <option value="0" selected>Hayır</option>
                                        <option value="1">Evet</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="rental_type" class="form-label">Kiralama Tipi</label>
                                    <select id="rental_type" name="rental_type" class="form-select">
                                        <option value="none" selected>Yok</option>
                                        <option value="daily">Günlük</option>
                                        <option value="weekly">Haftalık</option>
                                        <option value="monthly">Aylık</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="min_rent_duration" class="form-label">Minimum Kiralama Süresi (gün)</label>
                                    <input type="number" id="min_rent_duration" name="min_rent_duration" class="form-control" min="0">
                                </div>

                                <div class="col-md-2">
                                    <label for="max_rent_duration" class="form-label">Maksimum Kiralama Süresi (gün)</label>
                                    <input type="number" id="max_rent_duration" name="max_rent_duration" class="form-control" min="0">
                                </div>

                                <div class="col-md-2">
                                    <label for="rental_km_limit" class="form-label">Kiralama Km Limiti (km)</label>
                                    <input type="number" id="rental_km_limit" name="rental_km_limit" class="form-control" min="0">
                                </div>

                                <div class="col-md-2">
                                    <label for="over_km_price" class="form-label">Km Aşım Ücreti (₺/km)</label>
                                    <input type="number" step="0.01" id="over_km_price" name="over_km_price" class="form-control" min="0">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Satılık Mı ?</label>
                                    <select id="is_for_sale" name="is_for_sale" class="form-select">
                                        <option value="0" selected>Hayır</option>
                                        <option value="1">Evet</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="price" class="form-label">Fiyat (₺)</label>
                                    <input type="number" step="0.01" id="price" name="price" class="form-control" min="0">
                                </div>

                                <hr class="my-4" />

                                <!-- Plaka & Kilometre -->
                                <h3 class="mb-3">Plaka & Kilometre</h3>

                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <label for="plate" class="form-label mb-0">Plaka</label>
                                        <input type="text" id="plate" name="plate" class="form-control">
                                    </div>

                                    <div class="form-check form-switch" style="white-space: nowrap;">
                                        <input class="form-check-input" type="checkbox" id="is_plate_hidden" name="is_plate_hidden" value="1" />
                                        <label class="form-check-label" for="is_plate_hidden" style="font-size: 0.85rem;">Gizli</label>
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <label for="km" class="form-label mb-0">Kilometre</label>
                                        <input type="number" id="km" name="km" class="form-control" min="0">
                                    </div>

                                    <div class="form-check form-switch" style="white-space: nowrap;">
                                        <input class="form-check-input" type="checkbox" id="is_km_hidden" name="is_km_hidden" value="1" />
                                        <label class="form-check-label" for="is_km_hidden" style="font-size: 0.85rem;">Gizli</label>
                                    </div>
                                </div>

                                <hr class="my-4" />

                                <!-- Konum Bilgileri -->
                                <h3 class="mb-3">Konum Bilgileri</h3>

                                <div class="col-md-4">
                                    <label for="country" class="form-label">Ülke</label>
                                    <select id="country" name="country" class="form-control select2" style="width: 100%;placeholder="Ara.." >
                                        <option value="">Ülke Seçin</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label">İl</label>
                                    <select id="city" name="city" class="form-control select2" style="width: 100%;" placeholder="Ara.." disabled>
                                        <option value="">İl Seçin</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="district" class="form-label">İlçe</label>
                                    <select id="district" name="district" class="form-control select2" style="width: 100%;" placeholder="Ara.." disabled>
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="location_address" class="form-label">Adres</label>
                                    <input type="text" id="location_address" name="location_address" class="form-control">
                                </div>

                                <hr class="my-4" />

                                <!-- Diğer Teknik Detaylar -->
                                <h3 class="mb-3">Diğer Teknik Detaylar</h3>

                                <div class="col-md-3">
                                    <label for="engine_size" class="form-label">Motor Hacmi (Litre)</label>
                                    <input type="number" step="0.01" id="engine_size" name="engine_size" class="form-control" min="0" max="10">
                                </div>

                                <div class="col-md-3">
                                    <label for="horse_power" class="form-label">Motor Gücü (HP)</label>
                                    <input type="number" id="horse_power" name="horse_power" class="form-control" min="0">
                                </div>

                                <div class="col-md-3">
                                    <label for="tramers_price" class="form-label">Tramer Fiyatı (₺)</label>
                                    <input type="number" step="0.01" id="tramers_price" name="tramers_price" class="form-control" min="0">
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label">Ağır Hasar Kaydı</label>
                                    <select id="heavy_damage_record" name="heavy_damage_record" class="form-select">
                                        <option value="0" selected>Yok</option>
                                        <option value="1">Var</option>
                                    </select>
                                </div>

                                <hr class="my-4" />

                                <!-- Açıklama -->
                                <h3 class="mb-3">Araç Açıklaması</h3>

                                <div class="col-md-12">
                                    <label for="description" class="form-label">Açıklama</label>
                                    <textarea id="description" name="description" class="form-control" rows="6"></textarea>
                                </div>



                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-info">Araç Ekle</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict';

        const form = document.getElementById('vehicleForm');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            // Ajax submit
            $.ajax({
                url: <?= BASE_URL ?> + "ajax/ajax.php?action=add_vehicle",
                method: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        toastr.success("Araç başarıyla eklendi!");
                        setTimeout(() => {
                            window.location.href = "vehicles_list.php";
                        }, 1000);
                    } else {
                        toastr.error("Hata: " + response.error);
                    }
                },
                error: function() {
                    toastr.error("Sunucu hatası. Lütfen tekrar deneyin.");
                }
            });
        });
    })();
</script>



<script src="<?= BASE_URL ?>assets/ckeditor4-4.22.1/ckeditor.js"></script>

<script>
    CKEDITOR.replace('description', {
        removeButtons: 'Image,Table,Source,Flash,Smiley,SpecialChar,PageBreak,Iframe,Anchor,Save,NewPage,Preview,Print,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,ShowBlocks,About',
        toolbar: [
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
            { name: 'paragraph',   items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent' ] },
            { name: 'styles',      items: [ 'Format' ] },
            { name: 'links',       items: [ 'Link', 'Unlink' ] },
            { name: 'tools',       items: [ 'Maximize' ] }
        ],
        removePlugins: 'elementspath',
        resize_enabled: false,
        height: 200
    });
</script>



<!-- Select2 CSS ve JS (AdminLTE ile uyumlu) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function () {
        $('.select2').select2();

        // Ülke listesini getir
        $.post(<?= BASE_URL ?> + "ajax/ajax.php?action=getCountries", { }, function (data) {
            $('#country').append(data);
        });

        // İl verisi
        $('#country').on('change', function () {
            const countryId = $(this).val();
            $('#city').prop('disabled', true).empty().append('<option value="">İl Seçin</option>');
            $('#district').prop('disabled', true).empty().append('<option value="">İlçe Seçin</option>');

            if (countryId) {
                $.post(<?= BASE_URL ?> + "ajax/ajax.php?action=getCities", { country_id: countryId }, function (data) {
                    $('#city').append(data).prop('disabled', false);
                });
            }
        });

        // İlçe verisi
        $('#city').on('change', function () {
            const cityId = $(this).val();
            $('#district').prop('disabled', true).empty().append('<option value="">İlçe Seçin</option>');

            if (cityId) {
                $.post(<?= BASE_URL ?> + "ajax/ajax.php?action=getDistricts", { city_id: cityId }, function (data) {
                    $('#district').append(data).prop('disabled', false);
                });
            }
        });
    });
</script>


<?php include("../includes/footer.php"); ?>
