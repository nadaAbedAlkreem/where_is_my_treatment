$(document).ready(function($)
{



    //get data for update
    $(".data-table-admins").on('click', '.updateRe', function (e) {

        $('#id-update').val($(this).data("id"));
        $('#name-update').val($(this).data("name"));
        $('#email-update').val($(this).data("email"));
        $('#phone-update').val($(this).data("phone"));  //role-admin
        // ($(this).data("roles") === 'admin')?  $('#role-admin').prop('checked', true) :  $('#role-employee').prop('checked', true);


    });
    // $('#sort-date').change(function() {
    //     var order = $(this).val();
    //     table.order([6, order]).draw();
    // });

    $('#search-admin').on('input', function () {
        $(".data-table-admins").DataTable().ajax.reload();
    });

    $('#submit-status').on('click', function () {
        $(".data-table-admins").DataTable().ajax.reload();
    });

    $("#submitAdmins").on("click", function (e) {
        e.preventDefault();

        let formData = new FormData($("#formUpdateAdmins")[0]);
        let userId = document.getElementById('userId').value;
        console.log('formData' +formData)
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: "admins/"+userId,
            data: formData,
            contentType: false, // determint type object
            processData: false, // processing on response
            success: function (response) {
                // const queryString = window.location.search;
                // const params = new URLSearchParams(queryString);
                // const lang = params.get('lang');
                // console.log(lang);
                // window.location.href = "/dashboard/admins/"+ lang;
                // loadCategories(locale);



            },

            error: function (response) {
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



    $(".data-table-admins").on('click', '.deleteRecord[data-id]', function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: 'هل انت  متأكد؟',
            text: 'سوف يتم تنفيذ هذا الاجراء',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم نفذ الحذف'
        }).then((result) => {
            if (result.isConfirmed) {
                var token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: "admin/admins-management/"+ id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function () {
                        $('.data-table-admins').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });

    $(".data-table-admins").on("click", ".blockRecord[data-id]", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var status = ($(this).data("status") === 'blocked') ? 'active'  : 'blocked' ;

        Swal.fire({
            title:'هل انت متأكد ؟',
            text: 'سوف يتم تنفيذ هذا الاجراء',
            icon: "warning",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: 'نعم  نفذ  !',
        }).then((result) => {
            if (result.isConfirmed) {
                var token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: "admin/admins-management/update-status/" + id + "/" +status,
                    type: "GET",
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function () {
                        $(".data-table-admins").DataTable().ajax.reload();

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });

});
