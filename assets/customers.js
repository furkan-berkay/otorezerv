// Sütunlar (DataTable'da kullanılan data key ve gösterilecek başlık)
var columns = [
    { data: 'first_name', title: 'Ad' },
    { data: 'second_name', title: 'İkinci Ad' },
    { data: 'last_name', title: 'Soyad' },
    { data: 'phone_number', title: 'Telefon Numarası' },
    { data: 'email', title: 'Email' },
    { data: 'national_id', title: 'TC' },
    { data: 'tax_id', title: 'Vergi No' },
    { data: 'location_address', title: 'Adres' },
    { data: 'location_country_id', title: 'Ülke' },
    { data: 'location_city_id', title: 'Şehir' },
    { data: 'location_district_id', title: 'İlçe' },
    { data: 'note', title: 'Not' },
    { data: 'is_active', title: 'Durum' },
    { data: 'notification_enabled', title: 'Bildirimler' },
    { data: 'created_at', title: 'Oluşturulma Tarihi' },
    { data: 'updated_at', title: 'Güncellenme Tarihi' }
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



// Filtrelenecek kolonlar (field adı ve label)
const filterableFields = [
    { name: 'first_name', label: 'Ad', type: 'text'},
    { name: 'second_name', label: 'İkinci Ad', type: 'text'},
    { name: 'last_name', label: 'Soyad', type: 'text'},
    { name: 'phone_number', label: 'Telefon Numarası', type: 'text'},
    { name: 'email', label: 'Email', type: 'text'},
    { name: 'national_id', label: 'TC', type: 'text'},
    { name: 'tax_id', label: 'Vergi No', type: 'text'},
    { name: 'location_address', label: 'Adres', type: 'text' },
    { name: 'location_id', label: 'Konum', type: 'location' },
    { name: 'note', label: 'Not', type: 'text'},
    { name: 'is_active', label: 'Durum', type: 'select', options: [{val:'1', text:'Aktif'}, {val:'0', text:'Pasif'}]},
    { name: 'notification_enabled', label: 'Bildirimler', type: 'select', options: [{val:'1', text:'Açık'}, {val:'0', text:'Kapalı'}]},
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
                            <li><a class="dropdown-item" href="customer-form?id=${data}"><i class="bi bi-eye me-1"></i>Görüntüle/Düzenle</a></li>
                            <li><a class="dropdown-item text-danger btn-delete" href="#" data-id="${data}"><i class="bi bi-trash me-1"></i>Sil</a></li>
                        </ul>
                    </div>
                `;
            }
        },
        first_name: { data: 'first_name' },
        second_name: { data: 'second_name' },
        last_name: { data: 'last_name' },
        phone_number: { data: 'phone_number' },
        email: { data: 'email' },
        national_id: { data: 'national_id' },
        tax_id: { data: 'tax_id' },
        location_address: { data: 'location_address' },
        location_country_id: { data: 'location_country_name' },
        location_city_id: { data: 'location_city_name' },
        location_district_id: { data: 'location_district_name' },
        note: { data: 'note' }, //number format olmalı
        is_active: { data: 'is_active', render: data => data == 1 ? 'Aktif' : 'Pasif' },
        notification_enabled: { data: 'notification_enabled', render: data => data == 1 ? 'Açık' : 'Kapalı' },
        created_at: { data: 'created_at' },
        updated_at: { data: 'updated_at' },
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
    var table = $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: BASE_URL + "ajax/ajax?action=get_customers",
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
            data: { columns: selectedColumns, table_name: 'customers-table' },
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

    // Modalda sadece "phone_number" kolonunu işaretle
    $('#select-single-column').on('click', function () {
        $('#column-settings-form input[type="checkbox"]').prop('checked', false); // Hepsini kaldır
        $('#col_phone_number').prop('checked', true); // Sadece col_phone_number seç
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