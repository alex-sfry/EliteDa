export const tSelectRingsSettings = {
    searchField: 'system',
    valueField: 'system',
    labelField: 'system',
    plugins: ['dropdown_input'],
    sortField: [{ field: '$order' }, { field: '$score' }],
    loadThrottle: 500,
    hideSelected: true,
    highlight: false,
    shouldLoad: query => query.length < 2 ? false : true,
    load: async function (query, callback) {
        console.log(query);
        this.clearOptions();
        try {
            const response = await fetch(`/system/get/${query}`);
            if (response.ok) {
                callback(await response.json());
            } else {
                console.log('fetch error');
            }
        }
        catch (error) {
            console.log(error.message);
            callback();
        }
    }
};