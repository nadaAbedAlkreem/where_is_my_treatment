

let latInput = document.getElementById('latitude').value;
let lngInput = document.getElementById('longitude').value;

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
    console.log( latlng.lat.toFixed(6) + latlng.lng.toFixed(6))


 });

$('#submit-status-location').on('click', function () {

     $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var token = $("meta[name='csrf-token']").attr("content");
    let id_location = document.getElementById('id-location').value;
    let id_pharmacy = document.getElementById('id-pharmacy').value;
  console.log('long' + document.getElementById('longitude').value  +"lat" + document.getElementById('latitude').value)
    $.ajax({
        url: "admin/pharmacy-owner-management/update-location",
        type: "post",
        data: {
            lat: document.getElementById('latitude').value,
            lng: document.getElementById('longitude').value,
            id_location: id_location,
            id_pharmacy: id_pharmacy,
            _token: token,
        },
        success: function () {
            Swal.fire({
                text: "تم تحديث موقع الصيدلية",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });

        },
        error: function (error) {
            console.log(error);
        }
    });





});
