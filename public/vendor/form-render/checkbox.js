const checkboxSelectAll = $(`[checkbox-select-all]`);
checkboxSelectAll.on("change", function () {
    const checkboxList = $(this)
        .closest(`[card-item]`)
        .find(`[type="checkbox"]`);
    checkboxList.prop("checked", this.checked);
});

$(document).on("change", `[checkbox-select-item]`, function () {
    const checkboxList = $(this)
        .closest("[list-group]")
        .find(`[type="checkbox"]`);
    let isSelectedAll = true;
    checkboxList.each(function () {
        if ($(this).is(":checked") === false) {
            $(this)
                .closest(`[card-item]`)
                .find(`[checkbox-select-all]`)
                .prop("checked", false);

            isSelectedAll = false;
        }
    });

    if (isSelectedAll) {
        $(this)
            .closest(`[card-item]`)
            .find(`[checkbox-select-all]`)
            .prop("checked", true);
    }
});
