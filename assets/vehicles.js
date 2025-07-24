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
    { data: 'location_country_id', title: 'Ülke' },
    { data: 'location_city_id', title: 'Şehir' },
    { data: 'location_district_id', title: 'İlçe' },
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

function copyColorToClipboard(colorHex) {
    navigator.clipboard.writeText(colorHex).then(function() {
        // Başarılı
        $('#colorToastBody').text('Renk kodu kopyalandı: ' + colorHex);
        var toastEl = $('#colorToast')[0];
        var toast = bootstrap.Toast.getInstance(toastEl);
        if (!toast) {
            toast = new bootstrap.Toast(toastEl, { autohide: false });
        }
        toast.show();
    }).catch(function(err) {
        console.error('Kopyalama hatası:', err);
        alert('Renk kodu kopyalanamadı: ' + err.message);
    });

}


// Filtrelenecek kolonlar (field adı ve label)
const filterableFields = [
    { name: 'title', label: 'Başlık', type: 'text' },
    { name: 'brand', label: 'Marka', type: 'text' },
    { name: 'model', label: 'Model', type: 'text' },
    { name: 'year', label: 'Yıl (<=)', type: 'number', range: true },  // filtre için max fiyat gibi düşünebili, range: trueiz
    { name: 'price', label: 'Fiyat (<=)', type: 'number', range: true },  // filtre için max fiyat gibi düşünebili, range: trueiz
    { name: 'is_for_rent', label: 'Kiralık', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
    { name: 'is_for_sale', label: 'Satılık', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
    { name: 'status', label: 'Durum', type: 'select', options: [
            { val: 'available', text: 'Mevcut' },
            { val: 'reserved', text: 'Rezerve' },
            { val: 'sold', text: 'Satıldı' },
            { val: 'rented', text: 'Kirada' }
        ]
    },
    { name: 'plate', label: 'Plaka', type: 'text' },
    { name: 'is_plate_hidden', label: 'Plaka Gizli', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
    { name: 'km', label: 'KM (<=)', type: 'number', range: true },
    { name: 'is_km_hidden', label: 'KM Gizli', type: 'select', options: [{val:'1', text:'Evet'}, {val:'0', text:'Hayır'}] },
    { name: 'location_address', label: 'Adres', type: 'text' },
    { name: 'location_id', label: 'Konum', type: 'location' },
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
    { name: 'color', label: 'Renk', type: 'color' },
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
        <button type="button" class="btn btn-outline-danger btn-sm clear-filter-btn" style="height: 70%" title="Filtreyi Kaldır">
            <i class="bi bi-trash-fill"></i>
        </button>
    `;

$(document).ready(function() {
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
                                <li><a class="dropdown-item" href="vehicle-form?id=${data}"><i class="bi bi-eye me-1"></i>Görüntüle/Düzenle</a></li>
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
        price: { data: 'price' }, //number format olmalı
        is_for_rent: { data: 'is_for_rent', render: data => data == 1 ? 'Evet' : 'Hayır' },
        is_for_sale: { data: 'is_for_sale', render: data => data == 1 ? 'Evet' : 'Hayır' },
        status: { data: 'status' }, //tr olmalı
        created_at: { data: 'created_at' }, //d/m/Y H:i:s olmalı
        plate: { data: 'plate' },
        is_plate_hidden: { data: 'is_plate_hidden', render: data => data == 1 ? 'Evet' : 'Hayır' },
        km: { data: 'km' },
        is_km_hidden: { data: 'is_km_hidden', render: data => data == 1 ? 'Evet' : 'Hayır' },
        location_address: { data: 'location_address' },
        location_country_id: { data: 'location_country_name' }, //id değil ismi gelmeli
        location_city_id: { data: 'location_city_name' }, //id değil ismi gelmeli
        location_district_id: { data: 'location_district_name' }, //id değil ismi gelmeli
        gear_type: { data: 'gear_type' }, //tr olmalı
        fuel_type: { data: 'fuel_type' }, //tr olmalı
        engine_size: { data: 'engine_size' },
        horse_power: { data: 'horse_power' },
        color: { data: 'color' },
        body_type: { data: 'body_type' }, //tr olmalı
        description: { data: 'description' },
        rental_type: { data: 'rental_type' }, //tr olmalı
        min_rent_duration: { data: 'min_rent_duration' }, //yanında gün yazsın
        max_rent_duration: { data: 'max_rent_duration' }, //yanında gün yazsın
        tramers_price: { data: 'tramers_price' }, //number format olmalı
        traction: { data: 'traction' }, // büyük harfe çevirsek yeter gibi
        rental_km_limit: { data: 'rental_km_limit' },
        over_km_price: { data: 'over_km_price' }, //number format olmalı
        heavy_damage_record: { data: 'heavy_damage_record', render: data => data == 1 ? 'Evet' : 'Hayır' }
    };

    // selectedColumns dizisinden DataTables columns dizisi oluştur
    let columnsConfig = [];

    // Eğer id sütunu görünürlükte değilse bile ilk olarak ekleyebiliriz (opsiyonel)
    if (!selectedColumns.includes('id')) {
        columnsConfig.push(allColumns['id']);
    }

    selectedColumns.forEach(col => {
        if (allColumns[col]) {
            columnsConfig.push(allColumns[col]);
        }
    });

    // DataTable başlat
    var table = $('#vehicles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: BASE_URL + "ajax/ajax?action=get_vehicles",
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

                return $.extend({}, d, { filters: filterInputs });
            }
        },
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Hepsi"]
        ],
        columns: columnsConfig,
        order: [[0, 'desc']],
        /*dom:
            "<'row mb-3'<'col-md-6'l><'col-md-6 text-end'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",*/
        dom:
            "<'row mb-3'<'col-md-6'l><'col-md-6 text-end'>>" +  // 'f' (search) kaldırdım
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Ara...",
            lengthMenu: "Sayfa başına kayıt _MENU_",
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

    // Modal uygula butonuna tıklandığında seçilen sütunları al, DataTable'da göster/gizle, backend'e gönder
    $('#save-columns-btn').on('click', function() {
        var checkedBoxes = $('#column-settings-form input[type=checkbox]:checked');
        selectedColumns = [];
        checkedBoxes.each(function() {
            selectedColumns.push($(this).val());
        });


        // AJAX ile backend'e sütun seçimini gönder (JSON formatında)
        $.ajax({
            url: BASE_URL + 'ajax/ajax?action=save_columns',
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

    // Datatable arama inputunda yazdıkça checkboxları filtrele
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

    // Modalda tüm kolonları işaretle
    $('#select-all-columns').on('click', function () {
        $('#column-settings-form input[type="checkbox"]').prop('checked', true);
    });

    // Modalda sadece "title" kolonunu işaretle
    $('#select-single-column').on('click', function () {
        $('#column-settings-form input[type="checkbox"]').prop('checked', false); // Hepsini kaldır
        $('#col_title').prop('checked', true); // Sadece col_title seç
    });

    // filter-fields select2'yi başlat, optionları doldur
    filterableFields.forEach(field => {
        $('#filter-fields').append(new Option(field.label, field.name));
    });

    // Filtrelenecek alanlar select ini select2 yap
    $('#filter-fields').select2({
        placeholder: "Filtrelenecek alanları seçin",
        allowClear: true,
        width: '100%'
        // arama zaten varsayılan açık
    });

    // Arama kutusundaki tüm seelct optionları işaretle
    $('#select-all').on('click', function () {
        const allValues = filterableFields.map(field => field.name);
        $('#filter-fields').val(allValues).trigger('change');
    });

    // Arama kutusundaki tüm seelct optionları Kaldır
    $('#deselect-all').on('click', function () {
        $('#filter-fields').val(null).trigger('change');
    });

    // Seçilen alan değiştiğinde inputları dinamik oluştur
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
            else if (field.type === 'location') {
                let inputHtml = `
                    <label>Ülke</label>
                    <select class="form-select filter-input select2" id="filter_country_id" name="location_country_id" style="width: 100%;">
                        <option value="">Ülke Seçin</option>
                    </select>

                    <label class="mt-2">İl</label>
                    <select class="form-select filter-input select2" id="filter_city_id" name="location_city_id" disabled style="width: 100%;">
                        <option value="">İl Seçin</option>
                    </select>

                    <label class="mt-2">İlçe</label>
                    <select class="form-select filter-input select2" id="filter_district_id" name="location_district_id" disabled style="width: 100%;">
                        <option value="">İlçe Seçin</option>
                    </select>
                `;

                container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);

                // Select2 başlat
                $('#filter_country_id, #filter_city_id, #filter_district_id').select2({ width: '100%', allowClear: true });

                // Ülkeleri getir
                $.post(BASE_URL + "ajax/ajax?action=getCountries", {}, function (data) {
                    $('#filter_country_id').append(data);
                });

                // Değişim olayları
                $('#filter_country_id').on('change', function () {
                    let countryId = $(this).val();
                    $('#filter_city_id').prop('disabled', true).empty().append('<option value="">İl Seçin</option>');
                    $('#filter_district_id').prop('disabled', true).empty().append('<option value="">İlçe Seçin</option>');

                    if (countryId) {
                        $.post(BASE_URL + "ajax/ajax?action=getCities", { country_id: countryId }, function (data) {
                            $('#filter_city_id').append(data).prop('disabled', false);
                        });
                    }
                });

                $('#filter_city_id').on('change', function () {
                    let cityId = $(this).val();
                    $('#filter_district_id').prop('disabled', true).empty().append('<option value="">İlçe Seçin</option>');

                    if (cityId) {
                        $.post(BASE_URL + "ajax/ajax?action=getDistricts", { city_id: cityId }, function (data) {
                            $('#filter_district_id').append(data).prop('disabled', false);
                        });
                    }
                });
            }
            else if (field.type === 'color') {
                let inputHtml = `
                    <label>Renk <small style="color:red;">(Ana renk seçin veya özel renk için "Diğer..." seçeneğini kullanın)</small></label>
                    <div class="input-group">
                        <input type="color" id="color-picker" value="#000000" disabled/>
                        <select id="color-select" class="form-select mb-2" aria-label="Ana renk seçimi">
                `;

                $.each(predefinedColors, function(hex, label) {
                    inputHtml += `<option value="${hex}">${label}</option>`;
                });

                inputHtml += `
                        <option value="custom">Diğer... </option>
                        </select>
                        <input type="hidden" name="color" class="filter-input" id="color-hidden" value="#000000">
                    </div>
                `;


                container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);


                const $colorInput = $('#color-picker');
                const $colorHidden = $('#color-hidden');

                function updateColorPicker() {
                    const selected = $('#color-select').val();

                    if (selected === 'custom') {
                        $colorInput.prop('disabled', false);
                        if (!$colorInput.val()) {
                            $colorInput.val('#000000');
                        }
                        $colorHidden.val($colorInput.val());
                    } else if (selected !== '') {
                        $colorInput.val(selected).prop('disabled', true);
                        $colorHidden.val(selected);
                    } else {
                        $colorInput.val('#000000').prop('disabled', true);
                        $colorHidden.val('');
                    }
                }

                $('#color-select').on('change', updateColorPicker);

                $colorInput.on('input', function () {
                    // Custom color seçiliyken kullanıcı renk değiştirirse hidden input'u güncelle
                    if ($('#color-select').val() === 'custom') {
                        $colorHidden.val($(this).val());
                    }
                });

            }
            else {
                // Diğer tipler (text vs)
                inputHtml += `<label for="${baseId}">${field.label}</label>`;
                inputHtml += `<input type="text" class="form-control filter-input" id="${baseId}" name="${field.name}" />`;
                container.append(`<div class="mb-3 col-md-6">${inputHtml}</div><div class="col-md-6 d-flex align-items-center">${clearBtnHtml}</div>`);
            }
        });
    });

    //  Ülke - İl - İlçe için bu hale çevirim
    $('#filter-inputs-container').on('click', '.clear-filter-btn', function () {
        let $btnCol = $(this).parent();
        let $inputCol = $btnCol.prev('.col-md-6');

        // Select2 destroy
        $inputCol.find('select.filter-input.select2').each(function () {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });

        // Inputlardan gelen tüm field isimlerini set olarak topla
        let removedFields = new Set();
        $inputCol.find('input, select').each(function () {
            let inputName = $(this).attr('name') || '';
            if (!inputName) return;

            let baseFieldName = inputName.replace(/(_min|_max)$/, '');
            removedFields.add(baseFieldName);
        });

        // Seçili filtreler
        let selected = $('#filter-fields').val() || [];

        // Eğer location ile ilgili input varsa filter-fields'den location_id'yi çıkar
        const locationFields = ['location_country_id', 'location_city_id', 'location_district_id'];
        const hasLocationInput = [...removedFields].some(f => locationFields.includes(f));

        if (hasLocationInput) {
            // location_id varsa çıkart
            selected = selected.filter(f => f !== 'location_id');
        }
        else {
            // Diğer durumlarda ilgili inputların baseFieldName'lerini çıkar
            selected = selected.filter(f => !removedFields.has(f));
        }

        $('#filter-fields').val(selected).trigger('change');

        // DOM'dan sil
        $inputCol.remove();
        $btnCol.remove();
    });

    // Filtreyi Sil butonuna tıklayınca ilgili inputları temizle -- İlk hali
    $('#filter-inputs-containerxx').on('click', '.clear-filter-btnxx', function() {
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

    $('#clearFilters').on('click', function () {
        // Tüm filtre inputlarını DOM'dan kaldır
        $('#filter-inputs-container').empty();

        // Select2 seçimlerini temizle
        $('#filter-fields').val(null).trigger('change');

        // Accordion'u kapat
        $('#filterCollapse').collapse('hide');

        // DataTable'ı filtresiz yeniden yükle
        table.ajax.reload();
    });


});


$(function() {
    $(".modal").draggable({
        handle: ".modal-header"
    });
});