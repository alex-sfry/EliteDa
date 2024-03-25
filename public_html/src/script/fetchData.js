export const fetchData = async (url) => {
    try {
        const res = await fetch(
            url, {
                method: 'GET',
                headers: {
                    contentType: 'application/json',
                },
            });
        if (res.ok) {
            return await res.json();
        }
    }
    catch (error) {
        console.log(error.message);
    }
};