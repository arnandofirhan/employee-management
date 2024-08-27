const handleInitCreate = (
    formId,
    formFields,
    buttons = {
        index: {
            text: "Back to list",
            btnClass: "btn btn-sm btn-secondary",
            action: function () {
                window.location.replace($(`${formId}`).attr("data-url-action"));
            },
        },
        reCreate: {
            text: "Recreate",
            btnClass: "btn btn-sm btn-primary",
            action: function () {
                window.location.reload();
            },
        },
    }
) => {
    FormValidation.formValidation(document.querySelector(`${formId}`), {
        fields: formFields,
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "is-invalid",
                eleValidClass: "is-valid",
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
        },
    }).on("core.form.valid", async function (e) {
        const form = $(e.formValidation.form);
        const actionUrl = form.data("url-action");
        const submitButton = form.find('[type="submit"]');

        submitButton.prop("disabled", true);
        submitButton.attr("data-kt-indicator", "on");
        await new Promise((resolve) => setTimeout(resolve, 1000));

        await $.ajax({
            url: `${actionUrl}`,
            type: "POST",
            data: new FormData(form[0]),
            enctype: "multipart/form-data",
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: async function (res) {
                if (res.meta?.success) {
                    $.confirm({
                        theme: KTThemeMode.getMode(),
                        title: "Success!",
                        content: `${res.meta?.message ?? ""}`,
                        type: "green",
                        buttons: buttons,
                    });
                } else {
                    $.confirm({
                        theme: KTThemeMode.getMode(),
                        title: "Oops!",
                        content: `${res.meta?.message ?? ""}`,
                        type: "red",
                        backgroundDismiss: true,
                        buttons: {
                            close: {
                                text: "Close",
                                btnClass: "btn btn-sm btn-secondary",
                                keys: ["enter", "esc"],
                                action: function () {},
                            },
                        },
                    });
                }

                submitButton.prop("disabled", false);
                submitButton.removeAttr("data-kt-indicator");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                const res = jQuery.parseJSON(jqXHR.responseText);
                $.confirm({
                    theme: KTThemeMode.getMode(),
                    title: "Oops!",
                    content: `${
                        res.meta?.message ??
                        "Sorry, looks like there are some errors detected, please try again."
                    }`,
                    type: "red",
                    backgroundDismiss: true,
                    buttons: {
                        close: {
                            text: "Close",
                            btnClass: "btn btn-sm btn-secondary",
                            keys: ["enter", "esc"],
                            action: function () {},
                        },
                    },
                });

                submitButton.prop("disabled", false);
                submitButton.removeAttr("data-kt-indicator");
            },
        });
    });
};
