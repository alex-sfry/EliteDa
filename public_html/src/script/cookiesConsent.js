export const cookiesConsent = () => {
    const cookieBox = document.querySelector(".cookies-consent-wrapper");
    const acceptBtn = cookieBox.querySelector("button");
    
    acceptBtn.addEventListener('click', () => {
        //setting cookie for 1 month, after one month it'll be expired automatically
        document.cookie = "CookieBy=ELIDA; max-age=" + 60 * 60 * 24 * 30;
        if (document.cookie) {
            //if cookie is set
            cookieBox.classList.add("hide"); //hide cookie box
        } else {
            //if cookie not set then alert an error
            alert(
                "Cookie can't be set! Please unblock this site from the cookie setting of your browser."
            );
        }
    });
    const checkCookie = document.cookie.indexOf("CookieBy=ELIDA"); //checking our cookie
    //if cookie is set then hide the cookie box else show it
    checkCookie === -1 ? cookieBox.classList.remove("hide") : cookieBox.classList.add("hide");
};