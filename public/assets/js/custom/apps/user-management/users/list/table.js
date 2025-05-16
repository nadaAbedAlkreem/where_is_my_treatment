"use strict";

var KTUsersList = function () {
    // Define shared variables
    var table = document.getElementById('kt_table_users');
    var datatable;
    var toolbarBase;
    var toolbarSelected;
    var selectedCount;

    // Private functions
    var initUserTable = function () {
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
        var  datatable = $('.data-table-admins').DataTable({
            language: language_datatables,
            processing: true,
            serverSide: true,
            ordering: true,
            searching: false,
            info: true,
            ajax: {
                url: "admin/home",
                data: function (d) {
                    d.filter_column_type_user = $('#filter_column_type_user').val();
                    d.search_admin = $('#search-admin').val();
                    d.filter_column_type_status = $('#status-user').val();

                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'action', name: 'action', searchable: false},
            ],

            order: [[1, 'asc']], // ترتيب حسب الاسم
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            responsive: true,
            dom: 'lfrtip',
            "drawCallback": function() {
                KTMenu.createInstances();
                // initToggleToolbar();
                // handleDeleteRows();
                // toggleToolbars();
            }
        });

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        datatable.on('draw', function () {
            initToggleToolbar();
            handleDeleteRows();
            toggleToolbars();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-employess-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();

        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-employess-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-employess-table-filter="filter"]');
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
        const resetButton = document.querySelector('[data-kt-employess-table-filter="reset"]');

        // Reset datatable
        resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-employess-table-filter="form"]');
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
        const deleteButtons = table.querySelectorAll('[data-kt-categories-table-filter="delete_row"]');

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
                        url: "admin/admins-management/delete-multiple/",
                        type: "Post",
                        data: {
                            ids: selectedIds,
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

            initUserTable();
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
    KTUsersList.init();
});
