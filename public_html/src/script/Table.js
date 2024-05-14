export function Table(cnt) {
    this.cnt = cnt;
}

Table.prototype.getRows = function () {
    return $(`#${this.cnt} tbody tr`);
};

Table.prototype.fillTable = function (data, tblType) {
    function fillCellsShipsMods(cellIndex, rowIndex) {
        cellIndex === 0 && $(this).text(data[rowIndex].module || data[rowIndex].ship);
        cellIndex === 1 && $(this)
            .html(
                `<a href='/stations/details/${data[rowIndex].station_id}'>
                ${data[rowIndex].station}</a>`
            );
        cellIndex === 2 && $(this).text(data[rowIndex].type);
        if (cellIndex === 2 && data[rowIndex].surface) {
            $(this).addClass('text-success');
            $(this).removeClass('text-primary');
        } else if (cellIndex === 2) {
            $(this).addClass('text-primary');
            $(this).removeClass('text-success');
        }
        cellIndex === 3 && $(this).text(data[rowIndex].pad);
        cellIndex === 4 && $(this).text(data[rowIndex].system);
        cellIndex === 5 && $(this).text(data[rowIndex].distance_ly);
        cellIndex === 6 && $(this).text(data[rowIndex].distance_ls);
        cellIndex === 7 && $(this).text(data[rowIndex].time_diff);
    }
    
    function fillCellsCommodities (cellIndex, rowIndex) {
        cellIndex === 0 && $(this).text(data[rowIndex].commodity);
        cellIndex === 1 && $(this)
            .html(
                `<a href='/stations/details/${data[rowIndex].station_id}'>
                ${data[rowIndex].station}</a>`
            );
        cellIndex === 2 && $(this).text(data[rowIndex].type);
        if (cellIndex === 2 && data[rowIndex].surface) {
            $(this).addClass('text-success');
            $(this).removeClass('text-primary');
        } else if (cellIndex === 2) {
            $(this).addClass('text-primary');
            $(this).removeClass('text-success');
        }
        cellIndex === 3 && $(this).text(data[rowIndex].pad);
        cellIndex === 4 && $(this).text(data[rowIndex].system);
        cellIndex === 5 && $(this).text(data[rowIndex].distance_ly);
        cellIndex === 6 && $(this).text(data[rowIndex].distance_ls);
        cellIndex === 7 && $(this).text(
            data[rowIndex].demand ? data[rowIndex].demand : data[rowIndex].stock
        );
        cellIndex === 8 && $(this).text(
            `${data[rowIndex].sell_price ? data[rowIndex].sell_price : data[rowIndex].buy_price} Cr`
        );
        cellIndex === 9 && $(this).text(data[rowIndex].time_diff);
    }

    this.getRows().each(function (rowIndex) {
        if (!data[rowIndex]) {
            $(this).hide();
            return;
        }

        if ($(this).is(":hidden")) $(this).show();

        $(this).find('td').each(function (cellIndex) {
            tblType === 'commodities' && fillCellsCommodities.call(this, cellIndex, rowIndex);
            tblType === 'ships-mods' && fillCellsShipsMods.call(this, cellIndex, rowIndex);
        });
    });
};