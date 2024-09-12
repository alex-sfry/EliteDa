export const tSelectRingsSettings = (config) => {
    return {
        searchField: config.searchField,
        valueField: config.valueField,
        labelField: config.labelField,
        plugins: config.plugins,
        sortField: [{ field: '$order' }, { field: '$score' }],
        loadThrottle: 500,
        hideSelected: true,
        highlight: false,
        shouldLoad: query => query.length < 2 ? false : true,
        load: async function (query, callback) {
            this.clearOptions();
            try {
                const response = await fetch(`${config.endpoint}${query}/`);
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
};