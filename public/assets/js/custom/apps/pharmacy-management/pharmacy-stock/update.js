"use strict";

// Class definition
var KTUsersUpdatePharmacyStock = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_pharmacy_stock');
    const form = element.querySelector('#kt_modal_pharmacy_stock_form_update');
    const modal = new bootstrap.Modal(element);

    var initUpdatePharmacyStock = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    quantity: {
                        validators: {
                            notEmpty: {
                                message: 'الكمية مطلوبة'
                            },
                            numeric: {
                                message: 'يجب أن تكون الكمية رقمًا'
                            },
                            greaterThan: {
                                message: 'يجب أن تكون الكمية أكبر من 0',
                                min: 1
                            }
                        }
                    },
                    discount: {
                        validators: {
                            notEmpty: {
                                message: 'نسبة الخصم مطلوبة'
                            },
                            numeric: {
                                message: 'نسبة الخصم يجب أن تكون رقمًا'
                            },
                            between: {
                                min: 0,
                                max: 100,
                                message: 'النسبة يجب أن تكون بين 0 و 100'
                            }
                        }
                    },
                    'price': {
                        validators: {
                            notEmpty: {
                                message: 'قيمة السعر مطلوبة'
                            }
                        }
                    },
                    expiration_date: {
                        validators: {
                            notEmpty: {
                                message: 'تاريخ انتهاء الصلاحية مطلوب'
                            },
                            callback: {
                                message: 'تاريخ الانتهاء يجب أن يكون بعد تاريخ اليوم',
                                callback: function(input) {
                                    if (!input.value) {
                                        return false;
                                    }

                                    const enteredDate = new Date(input.value);
                                    const today = new Date();

                                    // اجعل التاريخ اليوم في منتصف الليل للمقارنة الدقيقة
                                    today.setHours(0, 0, 0, 0);
                                    enteredDate.setHours(0, 0, 0, 0);

                                    return enteredDate > today;
                                }
                            }
                        }
                    },

                    status: {
                        validators: {
                            notEmpty: {
                                message: 'يرجى اختيار حالة توفر الدواء'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );


        // Submit button handler
        const submitButton = element.querySelector('[data-kt-pharmacies-stock-modal-update-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        let formData = new FormData($("#kt_modal_pharmacy_stock_form_update")[0]);

                        let selectedTreatments = $('#treatment_id_2').val();
                        if (selectedTreatments && selectedTreatments.length > 0) {
                            let treatmentId = parseInt(selectedTreatments[0]);
                            formData.append('treatment_id', treatmentId);
                        }


                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        });
                        $.ajax({
                            type: "POST",
                            url: "admin/stock-pharmacy-management/update",
                            data: formData,
                            contentType: false, // determint type object
                            processData: false, // processing on response
                            success: function (response) {
                                $(".data-table-pharmacy-stock").DataTable().ajax.reload();

                                // Show loading indication
                                submitButton.setAttribute('data-kt-indicator', 'on');

                                // Disable button to avoid multiple click
                                submitButton.disabled = true;

                                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                setTimeout(function () {
                                    // Remove loading indication
                                    submitButton.removeAttribute('data-kt-indicator');

                                    // Enable button
                                    submitButton.disabled = false;

                                    // Show popup confirmation
                                    Swal.fire({
                                        text: "تم تحديث البيانات بنجاح ",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        if (result.isConfirmed) {
                                            modal.hide();
                                        }
                                    });

                                    form.reset(); // Submit form
                                    $('#treatment_id_2').val(null).trigger('change');

                                }, 2000);


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


                    } else {
                        // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

        // Cancel button handler
        const cancelButton = element.querySelector('[data-kt-pharmacies-stock-modal-update-action="cancel"]');
        cancelButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        // Close button handler
        const closeButton = element.querySelector('[data-kt-pharmacies-stock-modal-update-action="close"]');
        closeButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide();
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });
    }

    return {
        // Public functions
        init: function () {
            initUpdatePharmacyStock();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePharmacyStock.init();
});
