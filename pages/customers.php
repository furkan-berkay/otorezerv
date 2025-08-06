<?php
$current_page = "customers";
$page_title = "Müşteriler";
$breadcrumb_home = "Müşteriler";
$breadcrumb_home_link = "";
?>

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
    'first_name' => 'Ad',
    'second_name' => 'İkinci Ad',
    'last_name' => 'Soyad',
    'phone_number' => 'Telefon Numarası',
    'email' => 'Email',
    'national_id' => 'TC',
    'tax_id' => 'Vergi No',
    'location_address' => 'Adres',
    'location_country_id' => 'Ülke',
    'location_city_id' => 'Şehir',
    'location_district_id' => 'İlçe',
    'note' => 'Not',
    'is_active' => 'Durum',
    'notification_enabled' => 'Bildirimler',
    'created_at' => 'Oluşturulma Tarihi'
];
// Kullanıcının tercih ettiği sütunları al
$query = $db->prepare("
    SELECT column_name 
    FROM user_column_preferences 
    WHERE user_id = ? AND table_name = ?
    ORDER BY id ASC
");
$query->execute([$_SESSION["user_id"], "customers-table"]);
$columns = $query->fetchAll(PDO::FETCH_COLUMN);

// Hiç kayıt yoksa varsayılan olarak sadece 'Telefon Numarası' sütunu göster
if (empty($columns)) {
    $db->prepare("INSERT INTO user_column_preferences (user_id, table_name, column_name) VALUES (?, ?, ?)")
        ->execute([$_SESSION["user_id"], "customers-table", "phone_number"]);
    $columns = ['phone_number'];
}
?>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header"><h3 class="card-title">Müşteri Listesi</h3></div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="position-relative mb-3" style="width: 100%;">
                            <div class="accordion mb-3" id="filterAccordion" style="width: 50%">
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


                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-sm btn-info" id="select-all">Tümünü Seç</button>
                                                        <button type="button" class="btn btn-sm btn-warning" id="deselect-all">Tümünü Kaldır</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="filter-inputs-container" class="row mt-3"></div>
                                            <div class="row mt-3">
                                                <div class="col-6 pe-1">
                                                    <button id="clearFilters" class="btn btn-outline-danger w-100">Tüm Filtreleri Kaldır</button>
                                                </div>
                                                <div class="col-6 ps-1">
                                                    <button id="applyFilters" class="btn btn-primary w-100">Ara</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="customer-form"
                               class="btn btn-info btn-sm d-flex align-items-center shadow-sm position-absolute"
                               style="top: 0.25rem; right: 0.25rem; font-weight: 600;">
                                <i class="bi bi-plus-circle me-2" style="font-size: 1.2rem;"></i> Yeni Müşteri Ekle
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="customers-table" class="table table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" style="justify-items: center">
                                            <div class="d-flex align-items-center mb-2">
                                                <button id="column-settings-btn" class="btn btn-outline-secondary btn-sm me-2" title="Sütunları seç">
                                                    <i class="bi bi-gear-fill"></i>
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
                    <div class="card-footer clearfix">
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    var selectedColumns = <?php echo json_encode($columns); ?>;
</script>

<!-- Modal Hareket ettirebilme -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>


<script src="<?= BASE_URL ?>assets/customers.js"></script>

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


    .select2-container--default .select2-search--inline .select2-search__field {
        color: black !important;
        background-color: white !important;
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