export const fetchData = async (url, method = 'GET', body= null, loaderCnt = null) => {
    loaderCnt && enableLoader(loaderCnt);
    try {
        const res = await fetch(
            url, {
                method: method,
                mode: 'cors', // this cannot be 'no-cors'
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: body
            });
        if (res.ok) {
            return await res.json();
        } else {
            console.log('fetch error');
        }
    }
    catch (error) {
        console.log(error.message);
    }
    finally {
        loaderCnt && disableLoader(loaderCnt);
    }
};

function enableLoader(loaderCnt) {
    if (loaderCnt !== '') {
        $(loaderCnt).addClass('opacity-25');
    }
}

function disableLoader(loaderCnt) {
    $(loaderCnt).removeClass('opacity-25');
}