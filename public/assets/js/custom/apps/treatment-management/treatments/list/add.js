"use strict";

// Class definition
var KTUsersAddCategory = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_add_category');
    const form = element.querySelector('#kt_modal_add_category_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initAddCategory = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'image': {
                        validators: {
                            notEmpty: {
                                message: ' صورة الفئة مطلوب'
                            }
                        }
                    },
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'اسم الفئة مطلوب'
                            }
                        }
                    },
                    'description': {
                        validators: {
                            notEmpty: {
                                message: ' وصف الفئة مطلوب'
                            }
                        }
                    },

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
        const submitButton = element.querySelector('[data-kt-categories-modal-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {


                            let formData = new FormData($("#kt_modal_add_category_form")[0]);
                             $.ajaxSetup({
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                },
                            });
                            $.ajax({
                                type: "POST",
                                url: "admin/category-management/add",
                                data: formData,
                                contentType: false, // determint type object
                                processData: false, // processing on response
                                success: function (response) {
                                    $(".data-table-category").DataTable().ajax.reload();

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
                                            text: "تم اضافة البيانات بنجاح ",
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

                                        //form.submit(); // Submit form
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
        const cancelButton = element.querySelector('[data-kt-categories-modal-action="cancel"]');
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
        const closeButton = element.querySelector('[data-kt-categories-modal-action="close"]');
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
            initAddCategory();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddCategory.init();
});
