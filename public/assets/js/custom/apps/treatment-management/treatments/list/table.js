"use strict";

var KTTreatmentList = function () {
    // Define shared variables
    var table = document.getElementById('kt_table_treatment');
    var datatable;
    var toolbarBase;
    var toolbarSelected;
    var selectedCount;

    // Private functions
    var initTreatmentTable = function () {
        // Set date data order
        const tableRows = table.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const dateRow = row.querySelectorAll('td');
            const lastLogin = dateRow[3].innerText.toLowerCase(); // Get last login time
            let timeCount = 0;
            let timeFormat = 'minutes';

            // Determine date & time format -- add more formats when necessary
            if (lastLogin.includes('yesterday')) {
                timeCount = 1;
                timeFormat = 'days';
            } else if (lastLogin.includes('mins')) {
                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                timeFormat = 'minutes';
            } else if (lastLogin.includes('hours')) {
                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                timeFormat = 'hours';
            } else if (lastLogin.includes('days')) {
                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                timeFormat = 'days';
            } else if (lastLogin.includes('weeks')) {
                timeCount = parseInt(lastLogin.replace(/\D/g, ''));
                timeFormat = 'weeks';
            }

            // Subtract date/time from today -- more info on moment datetime subtraction: https://momentjs.com/docs/#/durations/subtract/
            const realDate = moment().subtract(timeCount, timeFormat).format();

            // Insert real date to last login attribute
            dateRow[3].setAttribute('data-order', realDate);

            // Set real date for joined column
            const joinedDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
            dateRow[5].setAttribute('data-order', joinedDate);
        });

        var language_datatables = {
            sEmptyTable: "لا يوجد بيانات ",
            sInfo: "يتم عرض _START_ إلى _END_ من _TOTAL_ من الإدخالات",
            sInfoEmpty: "عرض 0 إلى 0 من أصل 0 إدخالات",
            sInfoFiltered: "(تمت التصفية من إجمالي _MAX_ الإدخالات)",
            sInfoPostFix: "",
            sInfoThousands: "",
            sLengthMenu: "إظهار إدخالات _MENU_",
            sLoadingRecords: "جارٍ التحميل...",
            sProcessing: "جارٍ المعالجة...",
            sSearch: "البحث:",
            sZeroRecords: "لم يتم العثور على سجلات مطابقة",
            oPaginate: {
                sFirst: "الأولى",
                sLast: "الأخير",
                sNext: "التالي",
                sPrevious: "السابق",
            },
            oAria: {
                sSortAscending: ": التنشيط لفرز الأعمدة تصاعديًا",
                sSortDescending: ": التنشيط لفرز الأعمدة تنازليًا",
            },
        };

        // Init datatable --- more info on datatables: https://datatables.net/manual/
        var  datatable = $('.data-table-treatment').DataTable({
            language: language_datatables,
            processing: true,
            serverSide: true,
            ordering: true,
            searching: false,
            info: true,
            ajax: {
                url: "admin/treatment-management",
                data: function (d) {
                    d.search_treatment = $('#search-treatment').val();
                    d.filter_treatment_approved = $('#filter-treatment-approved').val();

                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'category', name: 'category'},
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'action', name: 'action', searchable: false},
            ],

            order: [[1, 'asc']], // ترتيب حسب الاسم
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
            dom: 'lfrtip',
            "drawCallback": function(settings) {
                KTMenu.createInstances();
                // initToggleToolbar();
                // handleDeleteRows();
                // toggleToolbars();
            }
        });
        $('#search-treatment').on('input', function () {
            $(".data-table-treatment").DataTable().ajax.reload();
        });
        $('#submit-status-tr').on('click', function () {
            $(".data-table-treatment").DataTable().ajax.reload();
        });
        $(".data-table-treatment").on("click", ".change-status[data-id]", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var currentStatus = $(this).data("status");
            var token = $("meta[name='csrf-token']").attr("content");

                    $.ajax({
                        url: "admin/treatment-management/update-status/" + id + "/" + currentStatus,
                        type: "GET",
                        data: {
                            id: id,
                            _token: token,
                        },
                        success: function () {
                            $(".data-table-treatment").DataTable().ajax.reload();  // تأكد أنك تعيد تحميل نفس الجدول الصحيح
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });

        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            initToggleToolbar();
            handleDeleteRows();
            toggleToolbars();
        });
    }
    $(".data-table-treatment").on('click', '.updateRe', function (e) {
        $('#id_update').val($(this).data("id"));
        $('#name_update').val($(this).data("name"));
        $('#description_update').val($(this).data("description"));
        $('#how_to_use_update').val($(this).data("how_to_use"));
        $('#side_effects_update').val($(this).data("side_effects"));
        $('#instructions_update').val($(this).data("instructions"));
        $('#category_id_update').val($(this).data("category_id"));
        $('#about_the_medicine_update').val($(this).data("about_the_medicine"));
        let imageUrl = $(this).data("image");
        console.log(imageUrl);
        $('.treatment-image-preview').css('background-image', 'url(' + imageUrl + ')');


    });
    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()



    // Cancel button handler
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();

        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-user-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            var filterString = '';

            // Get filter values
            selectOptions.forEach((item, index) => {
                if (item.value && item.value !== '') {
                    if (index !== 0) {
                        filterString += ' ';
                    }

                    // Build filter value options
                    filterString += item.value;
                }
            });

            // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
            datatable.search(filterString).draw();
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-user-table-filter="reset"]');

        // Reset datatable
        resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
            selectOptions.forEach(select => {
                $(select).val('').trigger('change');
            });

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            datatable.search('').draw();
        });
    }


    // Delete subscirption
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-location-pharmacy-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get user name
                const userName = parent.querySelectorAll('td')[1].querySelectorAll('a')[1].innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + userName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            text: "You have deleted " + userName + "!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function () {
                            // Remove current row
                            datatable.row($(parent)).remove().draw();
                        }).then(function () {
                            // Detect checked checkboxes
                            toggleToolbars();
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: customerName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }
    $(".data-table-treatment").on('click', '.deleteRecord[data-id]', function (e) {
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
                    url: "admin/treatment-management/"+ id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function () {
                        $('.data-table-treatment').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });

    // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');

        // Select elements
        toolbarBase = document.querySelector('[data-kt-user-table-toolbar="base"]');
        toolbarSelected = document.querySelector('[data-kt-user-table-toolbar="selected"]');
        selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');
        const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });
        $('#search-treatment').on('input', function () {
            $(".data-table-treatment").DataTable().ajax.reload();
        });


        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Are you sure you want to delete selected ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value)
                {
                    if (result.isConfirmed) {
                        const selectedIds = Array.from(document.querySelectorAll('.select-row:checked')).map(checkbox => checkbox.value);
                        console.log("Selected IDs:", selectedIds);
                        var token = $("meta[name='csrf-token']").attr("content");

                        $.ajax({
                            url: "admin/treatment-management/delete-multiple",
                            type: "post",
                            data: {
                                ids: selectedIds,
                                _token: token,
                            },
                            success: function () {
                                $(".data-table-treatment").DataTable().ajax.reload();

                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    }


                    checkboxes.forEach(c => {
                        if (c.checked) {
                            datatable.row($(c.closest('tbody tr'))).remove().draw();
                        }
                    });
                    const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                    headerCheckbox.checked = false;
                    toggleToolbars(); // Detect checked checkboxes
                    initToggleToolbar(); // Re-init toolbar to recalculate checkboxes

                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Selected customers was not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });
    }

    // Toggle toolbars
    const toggleToolbars = () => {
        // Select refreshed checkbox DOM elements
        const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');
        console.log('allCheckboxes'+ allCheckboxes);

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {

            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    return {
        // Public functions
        init: function () {
            if (!table) {
                return;
            }

            initTreatmentTable();
            initToggleToolbar();
            handleSearchDatatable();
            handleResetForm();
            handleDeleteRows();
            handleFilterDatatable();

        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTTreatmentList.init();
});



