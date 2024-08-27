const handleRenderEntity = (object) => {
    if (!object.id) {
        return object.text;
    }

    return `
        <div class="rows">
            <div class="col-sm-12">
                ${object.data.full_name}
            </div>
        </div>
    `;
};

const handleRenderMaster = (object) => {
    if (!object.id) {
        return object.text;
    }

    return `
        <div class="rows">
            <div class="col-sm-12">
                ${object.data.name}
            </div>
        </div>
    `;
};

const handleInitSelectEntity = (apiUrl, element, allowClear = false) => {
    $(element).select2({
        placeholder: "Select from the list",
        width: "100%",
        allowClear: allowClear,
        ajax: {
            url: `${apiUrl}`,
            dataType: "json",
            language: "id",
            type: "GET",
            delay: 450,
            data: function (params) {
                return {
                    term: params.term,
                };
            },
            processResults: function (res) {
                return {
                    results: $.map(res.data, function (object) {
                        return {
                            id: object.id,
                            text: object.full_name,
                            data: object,
                        };
                    }),
                };
            },
            cache: true,
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: handleRenderEntity,
        templateSelection: handleRenderEntity,
    });
};
