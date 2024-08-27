const handleInitTableFilter = (tableId, filterId) => {
    const filterSearch = document.querySelector(`${filterId}`);
    return filterSearch.addEventListener("keyup", function (e) {
        window.LaravelDataTables[`${tableId}`].search(e.target.value).draw();
    });
};
