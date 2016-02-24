"use strict";


class Cookie {

    constructor() {
    }

    createCookie(name, value, days) {
        let date = new Date();
        let expires = '';

        if (days) {
            date.setTime(date.getTime()+(days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toGMTString();
        }

        document.cookie = name + '=' + value + expires + '; path=/';
    }

    readCookie(name) {
        let nameEQ = name + '=';
        let ca = document.cookie.split(';');

        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length,c.length);
            }
        }
        return null;
    }

    eraseCookie(name) {
        this.createCookie(name, '', -1);
    }

}


export default Cookie;
