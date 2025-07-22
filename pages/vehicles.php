<?php require_once '../includes/init.php'; ?>
<?php include("../includes/header.php"); ?>


<style>
    #column-settings-form .row {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
    }

</style>


<?php

$columnHeaders = [
    'title' => 'Başlık',
    'brand' => 'Marka',
    'model' => 'Model',
    'year' => 'Yıl',
    'price' => 'Fiyat',
    'is_for_rent' => 'Kiralık',
    'is_for_sale' => 'Satılık',
    'status' => 'Durum',
    'created_at' => 'Oluşturulma Tarihi',
    'plate' => 'Plaka',
    'is_plate_hidden' => 'Plaka Gizli',
    'km' => 'KM',
    'is_km_hidden' => 'KM Gizli',
    'location_address' => 'Adres',
    'location_country_id' => 'Ülke ID',
    'location_city_id' => 'Şehir ID',
    'location_district_id' => 'İlçe ID',
    'gear_type' => 'Vites Tipi',
    'fuel_type' => 'Yakıt Tipi',
    'engine_size' => 'Motor Hacmi',
    'horse_power' => 'Motor Gücü',
    'color' => 'Renk',
    'body_type' => 'Kasa Tipi',
    'description' => 'Açıklama',
    'rental_type' => 'Kiralama Tipi',
    'min_rent_duration' => 'Min Kiralama Süresi',
    'max_rent_duration' => 'Max Kiralama Süresi',
    'tramers_price' => 'Tramer Fiyatı',
    'traction' => 'Çekiş Tipi',
    'rental_km_limit' => 'Km Limiti',
    'over_km_price' => 'Aşım Ücreti',
    'heavy_damage_record' => 'Ağır Hasar Kaydı'
];
// Kullanıcının tercih ettiği sütunları al
$query = $db->prepare("
    SELECT column_name 
    FROM user_column_preferences 
    WHERE user_id = ? AND table_name = ?
");
$query->execute([$_SESSION["user_id"], "vehicles-table"]);
$columns = $query->fetchAll(PDO::FETCH_COLUMN);

// Hiç kayıt yoksa varsayılan olarak sadece 'Başlık' sütunu göster
if (empty($columns)) {
    $db->prepare("INSERT INTO user_column_preferences (user_id, table_name, column_name) VALUES (?, ?, ?)")
        ->execute([$_SESSION["user_id"], "vehicles-table", "title"]);
    $columns = ['title'];
}
?>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>


<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- Responsive extension Bootstrap 5 CSS (yuvarlak + ikon için) -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header"><h3 class="card-title">Araç Listesi</h3></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="accordion mb-3" id="filterAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="filterHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                        🔍 Filtreleme Seçenekleri
                                    </button>
                                </h2>
                                <div id="filterCollapse" class="accordion-collapse collapse" aria-labelledby="filterHeading" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="filter-fields">Filtrelenecek Alan(lar):</label>
                                                <select id="filter-fields" multiple="multiple" style="width: 100%"></select>
                                            </div>
                                        </div>
                                        <div id="filter-inputs-container" class="row mt-3"></div>
                                        <div class="row mt-3">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button id="applyFilters" class="btn btn-primary w-100">Ara</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--<table class="table table-bordered">-->
                        <div class="table-responsive">
                            <table id="vehicles-table" class="table table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" style="justify-items: center">
                                            <div class="d-flex align-items-center mb-2">
                                                <button id="column-settings-btn" class="btn btn-outline-secondary btn-sm me-2" title="Sütunları seç">
                                                    <i class="bi bi-gear-fill"></i> <!-- Bootstrap Icons çark -->
                                                </button>
                                            </div>
                                        </th>
                                        <?php foreach ($columns as $col): ?>
                                            <th class="text-start align-top"><?= htmlspecialchars($columnHeaders[$col] ?? $col) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>

<div class="modal fade" id="columnSettingsModal" tabindex="-1" aria-labelledby="columnSettingsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="columnSettingsLabel">Görünecek Sütunları Seçin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-link btn-sm" id="select-all-columns">Tümünü Seç</button>
                        <button type="button" class="btn btn-link btn-sm" id="select-single-column">Bir Tane Seç</button>
                    </div>

                    <input type="text" id="column-search" class="form-control form-control-sm" style="max-width: 200px;" placeholder="Sütunlarda ara...">
                </div>

                <form id="column-settings-form">
                    <div class="row">
                        <!-- Checkboxlar JS ile buraya eklenecek -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-columns-btn">Uygula</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
            </div>
        </div>
    </div>
</div>



<script>
    // Sütunlar (DataTable'da kullanılan data key ve gösterilecek başlık)
    var columns = [
        { data: 'title', title: 'Başlık' },
        { data: 'brand', title: 'Marka' },
        { data: 'model', title: 'Model' },
        { data: 'year', title: 'Yıl' },
        { data: 'price', title: 'Fiyat' },
        { data: 'is_for_rent', title: 'Kiralık' },
        { data: 'is_for_sale', title: 'Satılık' },
        { data: 'status', title: 'Durum' },
        { data: 'created_at', title: 'Oluşturulma Tarihi' },
        { data: 'plate', title: 'Plaka' },
        { data: 'is_plate_hidden', title: 'Plaka Gizli' },
        { data: 'km', title: 'KM' },
        { data: 'is_km_hidden', title: 'KM Gizli' },
        { data: 'location_address', title: 'Adres' },
        { data: 'location_country_id', title: 'Ülke ID' },
        { data: 'location_city_id', title: 'Şehir ID' },
        { data: 'location_district_id', title: 'İlçe ID' },
        { data: 'gear_type', title: 'Vites Tipi' },
        { data: 'fuel_type', title: 'Yakıt Tipi' },
        { data: 'engine_size', title: 'Motor Hacmi' },
        { data: 'horse_power', title: 'Motor Gücü' },
        { data: 'color', title: 'Renk' },
        { data: 'body_type', title: 'Kasa Tipi' },
        { data: 'description', title: 'Açıklama' },
        { data: 'rental_type', title: 'Kiralama Tipi' },
        { data: 'min_rent_duration', title: 'Min Kiralama Süresi' },
        { data: 'max_rent_duration', title: 'Max Kiralama Süresi' },
        { data: 'tramers_price', title: 'Tramer Fiyatı' },
        { data: 'traction', title: 'Çekiş Tipi' },
        { data: 'rental_km_limit', title: 'Km Limiti' },
        { data: 'over_km_price', title: 'Aşım Ücreti' },
        { data: 'heavy_damage_record', title: 'Ağır Hasar Kaydı' }
    ];

    // Başlangıçta tüm sütunlar görünür kabul edelim
    //var selectedColumns = columns.map(function(c) { return c.data; });
    var selectedColumns = <?php echo json_encode($columns); ?>;

    function fillColumnCheckboxes(selectedCols) {
        var container = $('#column-settings-form .row');
        container.empty();
        $.each(columns, function(i, col) {
            var checked = selectedCols.indexOf(col.data) !== -1 ? 'checked' : '';
            var checkboxHtml = `
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${col.data}" id="col_${col.data}" ${checked}>
                        <label class="form-check-label" for="col_${col.data}">${col.title}</label>
                    </div>
                </div>
            `;
            container.append(checkboxHtml);
        });
    }


    // Filtrelenecek kolonlar (field adı ve label)
    const filterableFields = [
        { name: 'title', label: 'Başlık', type: 'text' },
        { name: 'brand', label: 'Marka', type: 'text' },
        { name: 'model', label: 'Model', type: 'text' },
        { name: 'year', label: 'Yıl', type: 'number' },
        { name: 'price', label: 'Fiyat (<=)', type: 'number', range: true },  // filtre için max fiyat gibi düşünebili, range: trueiz
        { name: 'is_for_rent', label: 'Kiralık', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
        { name: 'is_for_sale', label: 'Satılık', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
        { name: 'status', label: 'Durum', type: 'select', options: [
                { val: 'available', text: 'Available' },
                { val: 'reserved', text: 'Reserved' },
                { val: 'sold', text: 'Sold' },
                { val: 'rented', text: 'Rented' }
            ] },
        { name: 'plate', label: 'Plaka', type: 'text' },
        { name: 'is_plate_hidden', label: 'Plaka Gizli', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
        { name: 'km', label: 'KM (<=)', type: 'number', range: true },
        { name: 'is_km_hidden', label: 'KM Gizli', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
        { name: 'location_address', label: 'Adres', type: 'text' },
        { name: 'location_country_id', label: 'Ülke ID', type: 'number' },
        { name: 'location_city_id', label: 'Şehir ID', type: 'number' },
        { name: 'location_district_id', label: 'İlçe ID', type: 'number' },
        { name: 'gear_type', label: 'Vites Tipi', type: 'select', options: [
                { val: 'manual', text: 'Manuel' },
                { val: 'automatic', text: 'Otomatik' },
                { val: 'semi-automatic', text: 'Yarı Otomatik' }
            ] },
        { name: 'fuel_type', label: 'Yakıt Tipi', type: 'select', options: [
                { val: 'petrol', text: 'Benzin' },
                { val: 'diesel', text: 'Dizel' },
                { val: 'lpg', text: 'LPG' },
                { val: 'electric', text: 'Elektrik' },
                { val: 'hybrid', text: 'Hibrit' }
            ] },
        { name: 'engine_size', label: 'Motor Hacmi (<=)', type: 'number', range: true },
        { name: 'horse_power', label: 'Motor Gücü (<=)', type: 'number', range: true },
        { name: 'color', label: 'Renk', type: 'text' },
        { name: 'body_type', label: 'Kasa Tipi', type: 'select', options: [
                { val: 'sedan', text: 'Sedan' },
                { val: 'hatchback', text: 'Hatchback' },
                { val: 'suv', text: 'SUV' },
                { val: 'pickup', text: 'Pickup' },
                { val: 'coupe', text: 'Coupe' },
                { val: 'convertible', text: 'Convertible' },
                { val: 'van', text: 'Van' },
                { val: 'other', text: 'Diğer' }
            ] },
        { name: 'rental_type', label: 'Kiralama Tipi', type: 'select', options: [
                { val: 'daily', text: 'Günlük' },
                { val: 'weekly', text: 'Haftalık' },
                { val: 'monthly', text: 'Aylık' },
                { val: 'none', text: 'Yok' }
            ] },
        { name: 'min_rent_duration', label: 'Min Kiralama Süresi (>= gün)', type: 'number' },
        { name: 'max_rent_duration', label: 'Max Kiralama Süresi (<= gün)', type: 'number', range: true },
        { name: 'tramers_price', label: 'Tramer Fiyatı (<=)', type: 'number', range: true },
        { name: 'traction', label: 'Çekiş Tipi', type: 'select', options: [
                { val: 'fwd', text: 'Önden Çekiş' },
                { val: 'rwd', text: 'Arkadan İtiş' },
                { val: 'awd', text: '4 Tekerlekten Çekiş' },
                { val: '4wd', text: '4x4' },
                { val: 'other', text: 'Diğer' }
            ] },
        { name: 'rental_km_limit', label: 'KM Limiti (<=)', type: 'number', range: true },
        { name: 'over_km_price', label: 'Aşım Ücreti (<=)', type: 'number', range: true },
        { name: 'heavy_damage_record', label: 'Ağır Hasar Kaydı', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] }
    ];

    let clearBtnHtml = `
        <button type="button" class="btn btn-outline-danger btn-sm clear-filter-btn" title="Filtreyi Temizle">
            <i class="bi bi-trash-fill"></i>
        </button>
    `;

    $(document).ready(function() {

        let visibleColumns = <?php echo json_encode($columns); ?>;

        // DataTables için tüm sütunlar ve özellikleri (referans)
        const allColumns = {
            id: { data: 'id', orderable: false,
                render: function (data, type, row) {
                    return `
                        <div class="dropdown text-center">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="vehicle_edit.php?id=${data}"><i class="bi bi-eye me-1"></i>Görüntüle/Düzenle</a></li>
                                <li><a class="dropdown-item" href="vehicle_stock.php?id=${data}"><i class="bi bi-box-seam me-1"></i>Stok Güncelle</a></li>
                                <li><a class="dropdown-item btn-copy" href="#" data-id="${data}"><i class="bi bi-files me-1"></i>Kopyala</a></li>
                                <li><a class="dropdown-item text-danger btn-delete" href="#" data-id="${data}"><i class="bi bi-trash me-1"></i>Sil</a></li>
                            </ul>
                        </div>
                    `;
                }

            },
            title: { data: 'title' },
            brand: { data: 'brand' },
            model: { data: 'model' },
            year: { data: 'year' },
            price: { data: 'price' },
            is_for_rent: { data: 'is_for_rent', render: data => data == 1 ? 'Evet' : 'Hayır' },
            is_for_sale: { data: 'is_for_sale', render: data => data == 1 ? 'Evet' : 'Hayır' },
            status: { data: 'status' },
            created_at: { data: 'created_at' },
            plate: { data: 'plate' },
            is_plate_hidden: { data: 'is_plate_hidden', render: data => data == 1 ? 'Evet' : 'Hayır' },
            km: { data: 'km' },
            is_km_hidden: { data: 'is_km_hidden', render: data => data == 1 ? 'Evet' : 'Hayır' },
            location_address: { data: 'location_address' },
            location_country_id: { data: 'location_country_id' },
            location_city_id: { data: 'location_city_id' },
            location_district_id: { data: 'location_district_id' },
            gear_type: { data: 'gear_type' },
            fuel_type: { data: 'fuel_type' },
            engine_size: { data: 'engine_size' },
            horse_power: { data: 'horse_power' },
            color: { data: 'color' },
            body_type: { data: 'body_type' },
            description: { data: 'description' },
            rental_type: { data: 'rental_type' },
            min_rent_duration: { data: 'min_rent_duration' },
            max_rent_duration: { data: 'max_rent_duration' },
            tramers_price: { data: 'tramers_price' },
            traction: { data: 'traction' },
            rental_km_limit: { data: 'rental_km_limit' },
            over_km_price: { data: 'over_km_price' },
            heavy_damage_record: { data: 'heavy_damage_record', render: data => data == 1 ? 'Evet' : 'Hayır' }
        };

        // visibleColumns dizisinden DataTables columns dizisi oluştur
        let columnsConfig = [];

        // Eğer id sütunu görünürlükte değilse bile ilk olarak ekleyebiliriz (opsiyonel)
        if (!visibleColumns.includes('id')) {
            columnsConfig.push(allColumns['id']);
        }

        visibleColumns.forEach(col => {
            if (allColumns[col]) {
                columnsConfig.push(allColumns[col]);
            }
        });

        // DataTable başlat
        var table = $('#vehicles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= BASE_URL ?>ajax/ajax.php?action=get_vehicles",
                type: 'POST',
                data: function(d) {
                    const filterInputs = {};

                    $('#filter-inputs-container').find('.filter-input').each(function() {
                        const $el = $(this);
                        const name = $el.attr('name');
                        let val = $el.val();

                        // Select2 için null kontrolü yap
                        if ($el.hasClass('select2-hidden-accessible')) {
                            val = $el.select2('val');
                        }

                        if (val !== null && val !== '') {
                            filterInputs[name] = val;
                        }
                    });

                    console.log('Filtreler:', filterInputs);

                    return $.extend({}, d, { filters: filterInputs });
                }

            },
            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "Hepsi"]
            ],
            columns: columnsConfig,
            order: [[0, 'desc']],
            dom:
                "<'row'<'col-sm-12 col-md-6'lf><'col-sm-12 col-md-6 text-end'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Ara...",
                lengthMenu: "Sayfa başına _MENU_ kayıt",
                info: "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
                paginate: {
                    first: "İlk",
                    last: "Son",
                    next: "Sonraki",
                    previous: "Önceki"
                },
                processing: "Yükleniyor..."
            },
            responsive: true, // Responsive aktif
        });


        // Çark butonuna tıklandığında modal aç
        $('#column-settings-btn').on('click', function() {
            fillColumnCheckboxes(selectedColumns);
            $('#columnSettingsModal').modal('show');
        });

        // Uygula butonuna tıklandığında seçilen sütunları al, DataTable'da göster/gizle, backend'e gönder
        $('#save-columns-btn').on('click', function() {
            console.log("sa");
            var checkedBoxes = $('#column-settings-form input[type=checkbox]:checked');
            selectedColumns = [];
            checkedBoxes.each(function() {
                selectedColumns.push($(this).val());
            });


            // AJAX ile backend'e sütun seçimini gönder (JSON formatında)
            $.ajax({
                url: '<?= BASE_URL ?>ajax/ajax.php?action=save_columns',
                type: 'POST',
                data: { columns: selectedColumns },
                success: function(response) {
                    try {
                        var res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.success) {
                            toastr.success('Sütun ayarları kaydedildi!');
                            // Modalı kapat
                            $('#columnSettingsModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                        else {
                            toastr.error('Kaydetme sırasında hata oluştu!');
                            // Modalı kapat
                            $('#columnSettingsModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    } catch(e) {
                        toastr.error('Sunucudan geçersiz cevap alındı!');
                        // Modalı kapat
                        $('#columnSettingsModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function() {
                    toastr.error('AJAX isteği başarısız oldu!');
                    // Modalı kapat
                    $('#columnSettingsModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });

            // Modalı kapat
            //$('#columnSettingsModal').modal('hide');
        });


        // Arama inputunda yazdıkça checkboxları filtrele
        $('#column-search').on('input', function() {
            var val = $(this).val().toLowerCase();
            $('#column-settings-form .form-check').each(function() {
                var label = $(this).text().toLowerCase();
                if (label.indexOf(val) !== -1) {
                    $(this).closest('.col-md-3').show();
                }
                else {
                    $(this).closest('.col-md-3').hide();
                }
            });
        });

        //Tün kolonları işaretle
        $('#select-all-columns').on('click', function () {
            $('#column-settings-form input[type="checkbox"]').prop('checked', true);
        });

        // Sadece "title" kolonunu işaretle
        $('#select-single-column').on('click', function () {
            $('#column-settings-form input[type="checkbox"]').prop('checked', false); // Hepsini kaldır
            $('#col_title').prop('checked', true); // Sadece col_title seç
        });



        // 1) filter-fields select2'yi başlat, optionları doldur
        filterableFields.forEach(field => {
            $('#filter-fields').append(new Option(field.label, field.name));
        });
        /*$('#filter-fields').select2({
            placeholder: 'Filtrelenecek alanları seçin',
            allowClear: true
        });*/
        $('#filter-fields').select2({
            placeholder: "Filtrelenecek alanları seçin",
            allowClear: true,
            width: '100%',
            // arama zaten varsayılan açık
        });

        // 2) Seçilen alan değiştiğinde inputları dinamik oluştur
        $('#filter-fields').on('change', function() {
            const selected = $(this).val();
            const container = $('#filter-inputs-container');
            container.empty();

            if (!selected || selected.length === 0) {
                container.append('<p>Filtrelemek için alan seçin.</p>');
                return;
            }

            selected.forEach(fieldName => {
                const field = filterableFields.find(f => f.name === fieldName);
                if (!field) return;

                let inputHtml = '';
                const baseId = 'filter_' + field.name;

                if (field.type === 'select') {
                    // Select input
                    inputHtml += `<label for="${baseId}">${field.label}</label>`;
                    inputHtml += `<select class="form-select filter-input" id="${baseId}" name="${field.name}">`;
                    inputHtml += `<option value="">Seçiniz</option>`;
                    field.options.forEach(opt => {
                        inputHtml += `<option value="${opt.val}">${opt.text}</option>`;
                    });
                    inputHtml += `</select>`;

                    container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);
                    $(`#${baseId}`).select2({
                        placeholder: `Seçiniz`,
                        allowClear: true,
                        width: '100%'
                    });
                }
                else if (field.type === 'number' && field.range) {
                    // Numeric aralık: min ve max input
                    inputHtml += `<label>${field.label} Aralığı</label>`;
                    inputHtml += `<div class="d-flex gap-2">`;
                    inputHtml += `<input type="number" class="form-control filter-input" id="${baseId}_min" name="${field.name}_min" placeholder="Min" />`;
                    inputHtml += `<input type="number" class="form-control filter-input" id="${baseId}_max" name="${field.name}_max" placeholder="Max" />`;
                    inputHtml += `</div>`;

                    container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);
                }
                else if (field.type === 'number') {
                    // Tek numeric input (eğer range değilse)
                    inputHtml += `<label for="${baseId}">${field.label}</label>`;
                    inputHtml += `<input type="number" class="form-control filter-input" id="${baseId}" name="${field.name}" />`;
                    container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);
                }

                else {
                    // Diğer tipler (text vs)
                    inputHtml += `<label for="${baseId}">${field.label}</label>`;
                    inputHtml += `<input type="text" class="form-control filter-input" id="${baseId}" name="${field.name}" />`;
                    container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);
                }
            });
        });

        // Filtreyi Sil butonuna tıklayınca ilgili inputları temizle
        $('#filter-inputs-container').on('click', '.clear-filter-btn', function() {
            let $btnCol = $(this).parent();
            let $inputCol = $btnCol.prev('.col-md-6');

            // Input ve buton kolonlarını komple kaldır
            $inputCol.remove();
            $btnCol.remove();

            // Select2'den de kaldırmak için field adını çıkar
            let inputName = $inputCol.find('input, select').first().attr('name') || '';
            let baseFieldName = inputName.replace(/(_min|_max)$/, '');

            // Select2'de seçili olanlardan kaldır
            let selected = $('#filter-fields').val() || [];
            selected = selected.filter(f => f !== baseFieldName);
            $('#filter-fields').val(selected).trigger('change');
        });

        $('#applyFilters').on('click', function() {
            table.ajax.reload();
        });

    });
</script>



<?php include("../includes/footer.php"); ?>

<style>
    /* DataTables Responsive ikonları için override */
    table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
        content: "+";
    }
    table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.dtr-control:before{
        content: "-";
    }


    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #fff !important;
        color: #000 !important;
    }
</style>