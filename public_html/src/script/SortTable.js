export function SortTable(cnt, fetchData, table =null, pagination = null) {
    this.cnt = cnt;
    this.pagination = pagination;
    this.fetchData = fetchData;
    this.data = null;
    this.table = table;
}

SortTable.prototype.handleClick = async function(e) {
    e.preventDefault();
    const data = await this.fetchData($(e.currentTarget).attr('href'));
    // console.log(data);
    this.data = data;
    this.pagination && this.pagination.resetPagination.apply(this.pagination, [data.limit, data.totalCount]);
    $('a.sort').removeClass(['asc', 'desc', 'sorted']);

    if (Object.values(data.attributeOrders)[0] === 4) {
        $(e.currentTarget).addClass(['sorted', 'asc']);
    } else $(e.currentTarget).addClass(['sorted', 'desc']);

    $(e.currentTarget).attr('href', data.sortUrl);
};

SortTable.prototype.setEventListeners = function() {
    $(this.cnt + ' .sort').on('click', (e) => this.handleClick(e));
};
