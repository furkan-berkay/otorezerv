
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

        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        // FormData oluştur (formdaki tüm inputları otomatik alır)
        let formData = new FormData(form);

        // uploadedImages dizisindeki dosyaları ekle (null olanları atla)
        uploadedImages.filter(f => f !== null).forEach((file, index) => {
            formData.append('vehicle_images[]', file);
        });


        let damageJson = JSON.stringify(getVehicleDamageData());
        formData.append('damage_data', damageJson);

        // Ajax submit
        $.ajax({
            url: BASE_URL + "ajax/ajax?action=" + ajax_url,
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,    // *** EKLENDİ
            processData: false,    // *** EKLENDİ
            success: function(response) {
                if (response.success) {
                    toastr.success("Araç başarıyla eklendi!");
                    setTimeout(() => {
                        if (response.id) {
                            //window.location.href = 'vehicle-form?id=' + response.id;
                        }
                        else {
                            //window.location.href = 'vehicle-form';
                        }
                    }, 1000);
                }
                else {
                    toastr.error("Hata: " + response.error);
                }
            },
            error: function() {
                toastr.error("Sunucu hatası. Lütfen tekrar deneyin.");
            }
        });
    });
})();


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


let currentImageIndex = 0;
let allImages = [];

function showImagePreview(src) {
    $('#imagePreviewModalImg').attr('src', src);
    var modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
}

// Önizleme için görsel seçildiğinde
$(document).on('click', '#preview img', function() {
    allImages = $('#preview img').map(function() { return $(this).attr('src'); }).get();
    currentImageIndex = allImages.indexOf($(this).attr('src'));
    showImagePreview(allImages[currentImageIndex]);
});

// İleri ve Geri butonları
$('#nextImageBtn').on('click', function() {
    if (allImages.length === 0) return;
    currentImageIndex = (currentImageIndex + 1) % allImages.length;
    $('#imagePreviewModalImg').attr('src', allImages[currentImageIndex]);
});

$('#prevImageBtn').on('click', function() {
    if (allImages.length === 0) return;
    currentImageIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
    $('#imagePreviewModalImg').attr('src', allImages[currentImageIndex]);
});


let uploadedImages = []; // Yeni yüklenen görseller
let existingImages = []; // DB'den gelen görseller (düzenleme modunda)

function handleFiles(files) {
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        if (!file.type.match('image.*')) continue;

        let reader = new FileReader();
        reader.onload = function (e) {
            let src = e.target.result;
            let index = uploadedImages.push(file) - 1;

            $('#preview').append(`
                    <div class="position-relative m-1">
                        <img src="${src}" style="width: 70px; height: 70px; object-fit: cover;" class="border">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeUploadedImage(${index}, this)">×</button>
                    </div>
                `);
        };
        reader.readAsDataURL(file);
    }
}

function removeUploadedImage(index, el) {
    uploadedImages.splice(index, 1);
    $(el).parent().remove();

    // input'u sıfırlayarak aynı dosya tekrar yüklenebilir hale gelir
    $('#vehicle_images').val('');
}

function loadExistingImages() {
    if (Array.isArray(existingImagesPHP)) {
        existingImagesPHP.forEach(function (img) {
            $('#preview').append(`
                <div class="position-relative m-1" data-existing-id="${img.id}">
                    <img src="${BASE_URL + img.file_path}" style="width: 70px; height: 70px; object-fit: cover;" class="border">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeExistingImage(${img.id}, this)">×</button>
                </div>
            `);
        });
    }
}


function removeExistingImage(id, el) {
    let deleted = $('#deleted_images').val();
    $('#deleted_images').val(deleted ? deleted + ',' + id : id);
    $(el).parent().remove();
}


/*Değişen Boyalı parçalar*/

let clickedElement = null;
const labelToClassMap = {
    'O': 'original-new',
    'LB': 'localpainted-new',
    'B': 'painted-new',
    'D': 'changed-new'
};
const damageStates = ['original-new', 'localpainted-new', 'painted-new', 'changed-new'];

const labels = {
    'original-new': '',
    'localpainted-new': 'LB',
    'painted-new': 'B',
    'changed-new': 'D'
};
$(document).on('click', '.carClick', function () {
    clickedElement = $(this);

    // Parça adı
    const partName = clickedElement.data('part') || 'Parça';

    // Modal başlığını güncelle
    $('#damageModalLabel').text(partName.charAt(0).toUpperCase() + partName.slice(1).replace(/-/g, ' '));

    // Mevcut span içeriğini al
    const currentLabel = clickedElement.find('span').text().trim();

    // Radio seçimlerini temizle
    $('input[name="damageRadio"]').prop('checked', false);

    // Hangi class seçili olacak
    const selectedClass = labelToClassMap[currentLabel] || 'original-new';

    // İlgili radio butonu seçili yap
    $(`input[name="damageRadio"][value="${selectedClass}"]`).prop('checked', true);

    $('#damageModal').modal('show');
});

$('input[name="damageRadio"]').on('change', function () {
    const selectedClass = $(this).val();

    if (!clickedElement) return;
    // -new ile biteni sil
    clickedElement.removeClass(function (index, className) {
        return (className.match(/(?:^|\s)(\w+-new)/g) || []).join(' ');
    });

    clickedElement.addClass(selectedClass);
    clickedElement.find('span').text(labels[selectedClass]);

    $('#damageModal').modal('hide');

    updateDamageInfoList();
});

function updateDamageInfoList() {
    const groups = {
        'localpainted-new': [],
        'painted-new': [],
        'changed-new': []
    };

    $('.carClick').each(function () {
        const $el = $(this);
        if ($el.hasClass('localpainted-new')) {
            groups['localpainted-new'].push($el.data('part'));
        }
        else if ($el.hasClass('painted-new')) {
            groups['painted-new'].push($el.data('part'));
        }
        else if ($el.hasClass('changed-new')) {
            groups['changed-new'].push($el.data('part'));
        }
    });

    const $container = $('.car-damage-info-list');
    $container.empty();

    let hasDamage = false;

    for (const group in groups) {
        if (groups[group].length === 0) continue;
        hasDamage = true;

        // ✅ Class ismini düzelt
        let titleClass = group === 'localpainted-new' ? 'local-painted-new' : group;
        let titleText = '';
        if (group === 'localpainted-new') titleText = 'Lokal Boyalı Parçalar';
        else if (group === 'painted-new') titleText = 'Boyalı Parçalar';
        else if (group === 'changed-new') titleText = 'Değişen Parçalar';

        const $ul = $('<ul></ul>');
        $ul.append(`<li class="pair-title ${titleClass}">${titleText}</li>`);

        groups[group].forEach(partName => {
            $ul.append(`<li class="selected-damage">${partName}</li>`);
        });

        $container.append($ul);
    }

    // ✅ Hiçbir parça yoksa Orijinal yazısını ekle
    if (!hasDamage) {
        const $ul = $('<ul></ul>');
        $ul.append(`<li class="pair-title other-pair">Orijinal</li>`);
        $ul.append(`<li class="selected-damage">Aracın tüm parçaları orijinaldır. Değişen ve boyalı parçası bulunmamaktadır.</li>`);
        $container.append($ul);
    }
}


function getVehicleDamageDataOld() {
    let damageData = [];

    $('.carClick').each(function () {
        const partClass = $(this).attr('class').split(' ')[0]; // direkt Türkçe class
        const stateClass = damageStates.find(cls => $(this).hasClass(cls));

        if (!partClass) return;

        let data = {
            part_name: partClass,
            original: stateClass === 'original-new' ? 1 : 0,
            replaced: stateClass === 'changed-new' ? 1 : 0,
            painted: stateClass === 'painted-new' ? 1 : 0,
            local_paint: stateClass === 'localpainted-new' ? 1 : 0
        };

        damageData.push(data);
    });

    return damageData;
}

function getVehicleDamageData() {
    const damageMap = {
        'original-new': 'original',
        'localpainted-new': 'local_paint',
        'painted-new': 'painted',
        'changed-new': 'replaced'
    };

    let damageData = {};

    $('.carClick').each(function () {
        const $el = $(this);
        const classList = $el.attr('class').split(' ');
        const partClass = classList[0]; // örn: 'front-bumper'

        const stateClass = classList.find(cls => damageMap[cls]);

        if (!partClass || !stateClass) return;

        const dbKey = partClass.replace(/-/g, '_'); // örn: 'front_bumper'

        damageData[dbKey] = damageMap[stateClass];
    });

    return damageData;
}




$(document).ready(function () {
    $('.select2').select2();

    const $country = $('#location_country_id');
    const $city = $('#location_city_id');
    const $district = $('#location_district_id');

    const selectedCountry = $country.data('selected-country');
    const selectedCity = $country.data('selected-city');
    const selectedDistrict = $country.data('selected-district');

    // Ülkeleri getir
    $.post(BASE_URL + "ajax/ajax?action=getCountries", {}, function (data) {
        $country.append(data);

        if (selectedCountry) {
            $country.val(selectedCountry).trigger('change');

            // Şehirleri getir
            $.post(BASE_URL + "ajax/ajax?action=getCities", { country_id: selectedCountry }, function (cityData) {
                $city.empty().append('<option value="">İl Seçin</option>').append(cityData).prop('disabled', false);

                if (selectedCity) {
                    $city.val(selectedCity).trigger('change');

                    // İlçeleri getir
                    $.post(BASE_URL + "ajax/ajax?action=getDistricts", { city_id: selectedCity }, function (districtData) {
                        $district.empty().append('<option value="">İlçe Seçin</option>').append(districtData).prop('disabled', false);

                        if (selectedDistrict) {
                            $district.val(selectedDistrict).trigger('change');
                        }
                    });
                }
            });
        }
    });

    // Normal değişimlerde çalışacaklar
    $country.on('change', function () {
        const countryId = $(this).val();
        $city.prop('disabled', true).empty().append('<option value="">İl Seçin</option>');
        $district.prop('disabled', true).empty().append('<option value="">İlçe Seçin</option>');

        if (countryId) {
            $.post(BASE_URL + "ajax/ajax?action=getCities", { country_id: countryId }, function (data) {
                $city.append(data).prop('disabled', false);
            });
        }
    });

    $city.on('change', function () {
        const cityId = $(this).val();
        $district.prop('disabled', true).empty().append('<option value="">İlçe Seçin</option>');

        if (cityId) {
            $.post(BASE_URL + "ajax/ajax?action=getDistricts", { city_id: cityId }, function (data) {
                $district.append(data).prop('disabled', false);
            });
        }
    });

    $('#plate').on('input', function () {
        $(this).val($(this).val().toUpperCase().replace(/\s/g, ''));
    });


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
        }
        else if (selected !== '') {
            $colorInput.val(selected).prop('disabled', true);
            $colorHidden.val(selected);
        }
        else {
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

    updateColorPicker(); // Sayfa yüklenince ilk durumu ayarla


    $('#vehicle_images').on('change', function (e) {
        handleFiles(e.target.files);
        // Aynı dosya tekrar yüklenebilsin diye input'u sıfırla
        $(this).val('');
    });

    $('#drop-area').on('dragover', function (e) {
        e.preventDefault();
    });

    $('#drop-area').on('drop', function (e) {
        e.preventDefault();
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    loadExistingImages();


    //console.log(damageData);
    //console.log(Object.keys(damageData).length);

    if (typeof damageData !== 'undefined' && Object.keys(damageData).length > 0) {
        Object.entries(damageData).forEach(([partKey, state]) => {
            // partKey örn: 'front_bumper', class ise 'front-bumper'
            const className = partKey.replace(/_/g, '-');
            const $part = $('.carClick.' + className);

            if ($part.length) {
                $part.removeClass('original-new localpainted-new painted-new changed-new');

                // Duruma göre class ekle
                if (state === 'changed-new') {
                    $part.addClass('changed-new');
                    $part.find('span').text(labels['changed-new']);
                }
                else if (state === 'painted-new') {
                    $part.addClass('painted-new');
                    $part.find('span').text(labels['painted-new']);
                }
                else if (state === 'localpainted-new') {
                    $part.addClass('localpainted-new');
                    $part.find('span').text(labels['localpainted-new']);
                }
                else {
                    // original-new için
                    $part.addClass('original-new');
                    $part.find('span').text(labels['original-new']);
                }
            }
        });


        // Listeyi güncelle
        updateDamageInfoList();

    }
    else {
        // Yeni araç ekleme modu - tüm parçalar orijinal
        $('.car-parts > div').each(function() {
            $(this).removeClass('localpainted-new painted-new changed-new').addClass('original-new');
            $(this).find('span').text('');
        });

        // Alt listeyi temizleyip orijinal mesajı göster
        const $container = $('.car-damage-info-list');
        $container.empty();
        $container.append(`
            <ul>
                <li class="pair-title other-pair">Orijinal</li>
                <li class="selected-damage">Aracın tüm parçaları orijinaldır. Değişen ve boyalı parçası bulunmamaktadır.</li>
            </ul>
        `);
    }

});

