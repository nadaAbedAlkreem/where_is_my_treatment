let latInput = parseFloat(document.getElementById('latitude').value) || 31.5010;
let lngInput = parseFloat(document.getElementById('longitude').value) || 34.4667;

let map = L.map('map').setView([latInput, lngInput], 17);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19
}).addTo(map);

let marker = L.marker([latInput, lngInput], { draggable: true }).addTo(map);

marker.on('dragend', function (e) {
    let latlng = marker.getLatLng();
    document.getElementById('latitude').value = latlng.lat.toFixed(6);
    document.getElementById('longitude').value = latlng.lng.toFixed(6);
    console.log(latlng.lat.toFixed(6), latlng.lng.toFixed(6));
});

$('#register-pharmacy').on('click', function () {

    let formData = new FormData($("#pharmacyRegistrationForm")[0]);
    const newPassword = generateRandomPassword(8);
    formData.append("latitude",  parseFloat(document.getElementById('latitude').value));
    formData.append("longitude",parseFloat(document.getElementById('longitude').value));
    formData.append("password",newPassword);
    console.log(parseFloat(document.getElementById('latitude').value), parseFloat(document.getElementById('longitude').value));

     $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

       $.ajax({
        url: "subscription-pharmacy-app",
        type: "post",
        data: formData,
        processData: false,   // منع تحويل البيانات إلى query string
        contentType: false,   // منع تعيين content-type تلقائي
        success: function () {
            console.log('aa')
            Swal.fire({
                text: "تم ارسال طلب اشتراك انتظر الموافقة",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });

        },
           error: function (response) {
            console.log(response);
               Swal.fire({
                   text: response.responseJSON.data.error,
                   icon: "error",
                   buttonsStyling: false,
                   confirmButtonText: 'ok !',
                   customClass: {
                       confirmButton: "btn btn-primary",
                   },
               });
           },
    });





});
function generateRandomPassword(length = 12) {
    const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+[]{}|;:,.<>?";
    let password = "";
    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * chars.length);
        password += chars[randomIndex];
    }
    return password;
}


