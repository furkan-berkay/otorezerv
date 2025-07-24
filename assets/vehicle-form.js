
(() => {
    'use strict';

    const form = document.getElementById('vehicleForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (!form.checkValidity()) { alert("sa");
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

});