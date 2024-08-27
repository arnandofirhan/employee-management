$(document).on("click", `[button-delete]`, function () {
    const thisRow = $(this).closest("tr");
    const url = `${indexUrl}/${thisRow.data("id")}`;

    $.confirm({
        theme: KTThemeMode.getMode(),
        title: "Confirm!",
        content: `Do you want to delete this list?`,
        type: "orange",
        autoClose: "cancel|5000",
        buttons: {
            cancel: {
                text: "Cancel",
                btnClass: "btn btn-sm btn-secondary",
                keys: ["esc"],
                action: function () {},
            },
            destroy: {
                text: "Yes, Delete",
                btnClass: "btn btn-sm btn-danger",
                keys: ["enter"],
                action: async function () {
                    $.ajax({
                        url: `${url}`,
                        type: "DELETE",
                        success: function (res) {
                            if (res.meta?.success) {
                                if ($(`#${tableId}`)) {
                                    window.LaravelDataTables[
                                        `${tableId}`
                                    ].ajax.reload(null, false);
                                }

                                $.confirm({
                                    theme: KTThemeMode.getMode(),
                                    title: "Success",
                                    content: `${res.meta?.message ?? ""}`,
                                    type: "green",
                                    backgroundDismiss: true,
                                    autoClose: "close|5000",
                                    buttons: {
                                        close: {
                                            text: "Close",
                                            btnClass:
                                                "btn btn-sm btn-secondary",
                                            keys: ["enter", "esc"],
                                            action: function () {},
                                        },
                                    },
                                });
                            } else {
                                $.confirm({
                                    theme: KTThemeMode.getMode(),
                                    title: "Oops!",
                                    content: `${res.meta?.message ?? ""}`,
                                    type: "red",
                                    buttons: {
                                        close: {
                                            text: "Close",
                                            btnClass:
                                                "btn btn-sm btn-secondary",
                                            keys: ["enter", "esc"],
                                            action: function () {},
                                        },
                                    },
                                });
                            }
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
                                buttons: {
                                    close: {
                                        text: "Close",
                                        btnClass: "btn btn-sm btn-secondary",
                                        keys: ["enter", "esc"],
                                        action: function () {},
                                    },
                                },
                            });
                        },
                    });
                },
            },
        },
    });
});
