"use strict";

// Class definition
var KTUsersUpdateTreatment= function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_treatment');
    const form = element.querySelector('#kt_modal_update_treatment_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdateTreatment = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'اسم الدواء مطلوب'
                            }
                        }
                    },
                    'description': {
                        validators: {
                            notEmpty: {
                                message: ' وصف الدواء مطلوب'
                            }
                        }
                    },
                    'about_the_medicine': {
                        validators: {
                            notEmpty: {
                                message: ' حول الدواء مطلوب'
                            }
                        }
                    },
                    'how_to_use': {
                        validators: {
                            notEmpty: {
                                message: ' كيفية استخدام الدواء مطلوب'
                            }
                        }
                    },
                    'instructions': {
                        validators: {
                            notEmpty: {
                                message: '  تعليمات الدواء مطلوب'
                            }
                        }
                    },
                    'side_effects': {
                        validators: {
                            notEmpty: {
                                message: '  تاثير الجانبي لدواء مطلوب'
                            }
                        }
                    },
                    'category_id': {
                        validators: {
                            notEmpty: {
                                message: '  الفئة التي ينتمي اليها الدواء مطلوب'
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
        const submitButton = element.querySelector('[data-kt-treatment-modal-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status === 'Valid') {

                        let formData = new FormData($("#kt_modal_update_treatment_form")[0]);
                         const form = document.getElementById("kt_modal_update_treatment_form");
                        // const button = document.getElementById('kt_sign_up_submit');
                        // const progress = button.querySelector('.indicator-label-progress');
                        // progress.classList.remove('hidden-progress');



                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        });


                        $.ajax({
                            type: "POST",
                            url: "admin/treatment-management/update",
                            data: formData,
                            contentType: false, // determint type object
                            processData: false, // processing on response
                            success: function (response) {
                                $("#successMsg").show();
                                // progress.classList.add('hidden-progress');
                                $(".data-table-treatment").DataTable().ajax.reload();
                                const submitButton = element.querySelector('[data-kt-treatment-modal-action="submit"]');
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
                                        text: "Form has been successfully submitted!",
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
                                // const dismissButton = document.getElementById('dismiss_create_admin');
                                form.reset();
                                // if (dismissButton) {
                                //     dismissButton.click();
                                // }

                            },

                            error: function (response) {
                                // progress.classList.add('hidden-progress');
                                Swal.fire({
                                    text: response.responseJSON.data.error,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: 'تم',
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            },
                        });
                        // // Show loading indication
                        // submitButton.setAttribute('data-kt-indicator', 'on');
                        //
                        // // Disable button to avoid multiple click
                        // submitButton.disabled = true;
                        //
                        // // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        // setTimeout(function () {
                        //     // Remove loading indication
                        //     submitButton.removeAttribute('data-kt-indicator');
                        //
                        //     // Enable button
                        //     submitButton.disabled = false;
                        //
                        //     // Show popup confirmation
                        //     Swal.fire({
                        //         text: "Form has been successfully submitted!",
                        //         icon: "success",
                        //         buttonsStyling: false,
                        //         confirmButtonText: "Ok, got it!",
                        //         customClass: {
                        //             confirmButton: "btn btn-primary"
                        //         }
                        //     }).then(function (result) {
                        //         if (result.isConfirmed) {
                        //             modal.hide();
                        //         }
                        //     });
                        //
                        //     //form.submit(); // Submit form
                        // }, 2000);
                    } else {
                        // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "يوجد اخطاء هنا حاول مرة اخرى ",
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
        const cancelButton = element.querySelector('[data-kt-treatment-modal-action="cancel"]');
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
        const closeButton = element.querySelector('[data-kt-treatment-modal-action="close"]');
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
            initUpdateTreatment();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateTreatment.init();
});
