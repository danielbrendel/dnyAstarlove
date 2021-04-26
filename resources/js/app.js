/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

require('./bootstrap');

window.vue = new Vue({
    el: '#main',

    data: {
        bShowRegister: false,
        bShowLogin: false,
        bShowRecover: false,

        translationTable: {
            usernameOk: 'The given name is valid and available',
            invalidUsername: 'The name is invalid. Please use only alphanumeric characters, numbers 0-9 and the characters \'-\' and \'_\'. Also number only identifiers are considered invalid',
            nonavailableUsername: 'The given name is already in use',
            passwordMismatching: 'The passwords do not match',
            passwordMatching: 'The passwords do match',
            age: 'Age',
            status: 'Status',
            location: 'Location',
            gender: 'Gender',
        },
    },

    methods: {
        invalidLoginEmail: function () {
            let el = document.getElementById("loginemail");

            if ((el.value.length == 0) || (el.value.indexOf('@') == -1) || (el.value.indexOf('.') == -1)) {
                el.classList.add('is-danger');
            } else {
                el.classList.remove('is-danger');
            }
        },

        invalidRecoverEmail: function () {
            let el = document.getElementById("recoveremail");

            if ((el.value.length == 0) || (el.value.indexOf('@') == -1) || (el.value.indexOf('.') == -1)) {
                el.classList.add('is-danger');
            } else {
                el.classList.remove('is-danger');
            }
        },

        invalidLoginPassword: function () {
            let el = document.getElementById("loginpw");

            if (el.value.length == 0) {
                el.classList.add('is-danger');
            } else {
                el.classList.remove('is-danger');
            }
        },

        ajaxRequest: function (method, url, data = {}, successfunc = function(data){}, finalfunc = function(){}, config = {})
        {
            let func = window.axios.get;
            if (method == 'post') {
                func = window.axios.post;
            } else if (method == 'patch') {
                func = window.axios.patch;
            } else if (method == 'delete') {
                func = window.axios.delete;
            }

            func(url, data, config)
                .then(function(response){
                    successfunc(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function(){
                        finalfunc();
                }
            );
        },

        initNavbar: function() {
            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    
            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {
    
                // Add a click event on each of them
                $navbarBurgers.forEach( el => {
                    el.addEventListener('click', () => {
    
                        // Get the target from the "data-target" attribute
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
    
                        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }
        },

        showUsernameValidity: function(username, hint, currentName = '') {
            window.vue.ajaxRequest('get', window.location.origin + '/member/name/valid?ident=' + username, {}, function(response) {
                if (response.code == 200) {
                    if ((currentName !== '') && (username === currentName)) {
                        hint.innerHTML = '';
                    } else if (!response.data.valid) {
                        hint.classList.add('is-danger');
                        hint.classList.remove('is-success');
                        hint.innerHTML = window.vue.translationTable.invalidUsername;
                    } else if (!response.data.available) {
                        hint.classList.add('is-danger');
                        hint.classList.remove('is-success');
                        hint.innerHTML = window.vue.translationTable.nonavailableUsername;
                    } else if ((response.data.valid) && (response.data.available)) {
                        hint.classList.remove('is-danger');
                        hint.classList.add('is-success');
                        hint.innerHTML = window.vue.translationTable.usernameOk;
                    }
                }
            });
        },
        
        showPasswordMatching: function(pw1, pw2, hint) {
            if ((pw1.length > 0) || (pw2.length > 0)) {
                if (pw1 !== pw2) {
                    hint.classList.remove('is-success');
                    hint.classList.add('is-danger');
                    hint.innerHTML = window.vue.translationTable.passwordMismatching;
                } else {
                    hint.classList.add('is-success');
                    hint.classList.remove('is-danger');
                    hint.innerHTML = window.vue.translationTable.passwordMatching;
                }
            }
        },

        showError: function()
        {
            document.getElementById('flash-error').style.display = 'inherit';
            setTimeout(function() { document.getElementById('flash-error').style.display = 'none'; }, 3500);
        },

        showSuccess: function()
        {
            document.getElementById('flash-success').style.display = 'inherit';
            setTimeout(function() { document.getElementById('flash-success').style.display = 'none'; }, 3500);
        },

        getSearchGeoRange: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_georange') !== -1) {
                    return cookies[i].substr(cookies[i].indexOf('=') + 1);
                }
            }

            return 1000;
        },

        setSearchGeoRange: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_georange=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        getSearchGenderMale: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_gender_male') !== -1) {
                    return parseInt(cookies[i].substr(cookies[i].indexOf('=') + 1));
                }
            }

            return true;
        },

        setSearchGenderMale: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_gender_male=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        getSearchGenderFemale: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_gender_female') !== -1) {
                    return parseInt(cookies[i].substr(cookies[i].indexOf('=') + 1));
                }
            }

            return true;
        },

        setSearchGenderFemale: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_gender_female=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        getSearchGenderDiverse: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_gender_diverse') !== -1) {
                    return parseInt(cookies[i].substr(cookies[i].indexOf('=') + 1));
                }
            }

            return true;
        },

        setSearchGenderDiverse: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_gender_diverse=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        getSearchAgeFrom: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_age_from') !== -1) {
                    return parseInt(cookies[i].substr(cookies[i].indexOf('=') + 1));
                }
            }

            return 18;
        },

        setSearchAgeFrom: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_age_from=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        getSearchAgeTill: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_age_till') !== -1) {
                    return parseInt(cookies[i].substr(cookies[i].indexOf('=') + 1));
                }
            }

            return 100;
        },

        setSearchAgeTill: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_age_till=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        getSearchOnlyOnline: function () {
            let cookies = document.cookie.split(';');

            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('search_onlyonline') !== -1) {
                    return parseInt(cookies[i].substr(cookies[i].indexOf('=') + 1));
                }
            }

            return false;
        },

        setSearchOnlyOnline: function(value) {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'search_onlyonline=' + value + '; expires=' + expDate.toUTCString() + ';';
        },

        renderProfileForm: function(elem) {
            let online = '';
            if (elem.is_online) {
                online = '<span class="profile-avatar-online"></span>';
            }

            let html = `
                <div class="profile">
                    <div class="profile-avatar">
                        <a href="` + window.location.origin + '/user/' + elem.name + `"><img src="` + window.location.origin + '/gfx/avatars/' + elem.avatar + `" alt="avatar"></a>
                        ` + online + `
                    </div>

                    <div class="profile-name"><a href="` + window.location.origin + '/user/' + elem.name + `">` + elem.name + `</a></div>

                    <div class="profile-info">
                        <div><strong>` + this.translationTable.age + `: </strong>` + elem.age + `</div>
                        <div><strong>` + this.translationTable.status + `: </strong>` + elem.rel_status + `</div>
                        <div><strong>` + this.translationTable.location + `: </strong>` + elem.location + `</div>
                        <div><strong>` + this.translationTable.gender + `: </strong>` + elem.gender + `</div>
                    </div>

                    <div class="profile-introduction">
                        ` + elem.introduction + `
                    </div>
                </div>
            `;

            return html;
        },
    }
});

document.addEventListener('DOMContentLoaded', function() {
    window.vue.initNavbar();
});