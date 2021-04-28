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
        bShowCreateFeature: false,
        bShowEditFeature: false,
        bShowCreateFaq: false,
        bShowEditFaq: false,

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
            isnew: 'New',
            removeIgnore: 'Remove'
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

        renderMessageListItem: function(item) {
            let html = `
                <div class="messages-item ` + ((!item.seen) ? 'is-new-message' : '') + `">
                    <div class="messages-item-avatar">
                        <img src="` + window.location.origin + `/gfx/avatars/` + item.user.avatar + `">
                    </div>
        
                    <div class="messages-item-name">
                        <a href="` + window.location.origin + `/u/` + item.user.name + `">` + item.user.name + `</a>
                    </div>
        
                    <div class="messages-item-subject">
                        <a href="` + window.location.origin + `/messages/show/` + item.id + `">` + item.subject + `</a>
                    </div>
        
                    <div class="messages-item-date" title="` + item.created_at + `">
                        ` + item.diffForHumans + `
                    </div>
                </div>
            `;
        
            return html;
        },

        showTabMenu: function(target) {
            let tabItems = ['tabVisitors', 'tabProfile', 'tabPhotos', 'tabSecurity', 'tabNotifications', 'tabIgnoreList', 'tabMembership'];

            tabItems.forEach(function(elem, index) {
               if (elem !== target) {
                   document.getElementById(elem).classList.remove('is-active');
                   document.getElementById(elem + '-form').classList.add('is-hidden');
               }

               document.getElementById(target).classList.add('is-active');
               document.getElementById(target + '-form').classList.remove('is-hidden');
            });
        },

        renderVisitorProfile: function(elem) {
            let isnew = '';
            if (elem.new) {
                isnew = '<span class="visitor-new">' + this.translationTable.isnew + '</span>';
            }

            let html = `
            <div class="visitor">
                <div class="visitor-avatar">
                    <a href="`+ window.location.origin + '/user/' + elem.user.name + `"><img src="`+ window.location.origin + '/gfx/avatars/' + elem.user.avatar + `" alt="avatar"></a>

                    ` + isnew + `
                </div>
        
                <div class="visitor-name">
                    <a href="`+ window.location.origin + '/user/' + elem.user.name + `">` + elem.user.name + `</a>
                </div>
            </div>
            `;

            return html;
        },

        renderIgnoreProfile: function(elem) {
            let html = `
            <div class="ignore">
                <div class="ignore-avatar">
                    <a href="`+ window.location.origin + '/user/' + elem.user.name + `"><img src="`+ window.location.origin + '/gfx/avatars/default.png' + `" alt="avatar"></a>
                </div>
        
                <div class="ignore-name">
                    <a href="`+ window.location.origin + '/user/' + elem.user.name + `">` + elem.user.name + `</a>
                </div>

                <div class="ignore-action">
                    <button class="button is-link" onclick="location.href = '` + window.location.origin + `/member/unignore/` + elem.user.id + `';">` + this.translationTable.removeIgnore + `</button>
                </div>
            </div>
            `;

            return html;
        },

        renderNotification: function(elem, newItem = false) {
            let icon = 'fas fa-info-circle';
            let color = 'is-notification-color-black';
            if (elem.type === 'PUSH_WELCOME') {
                icon = 'fas fa-gift';
                color = 'is-notification-color-green';
            } else if (elem.type === 'PUSH_VISITED') {
                icon = 'far fa-eye';
                color = 'is-notification-color-blue';
            } else if (elem.type === 'PUSH_LIKED') {
                icon = 'far fa-heart';
                color = 'is-notification-color-red';
            } else if (elem.type === 'PUSH_MESSAGED') {
                icon = 'far fa-envelope';
                color = 'is-notification-color-yellow';
            }

            let html = `
                <div class="notification-item ` + ((newItem) ? 'is-new-notification' : '') + `">
                    <div class="notification-icon">
                        <div class="notification-item-icon"><i class="` + icon + ` fa-3x ` + color + `"></i></div>
                    </div>
                    <div class="notification-info">
                        <div class="notification-item-message">` + elem.longMsg + `</div>
                        <div class="notification-item-message is-color-grey is-font-size-small is-margin-top-5">` + elem.diffForHumans + `</div>
                    </div>
                </div>
            `;

            return html;
        },

        toggleNotifications: function(ident) {
            let obj = document.getElementById(ident);
            if (obj) {
                if (obj.style.display === 'block') {
                    obj.style.display = 'none';
                } else {
                    obj.style.display = 'block';
                }
            }
        },

        markSeen: function() {
            this.ajaxRequest('get', window.location.origin + '/notifications/seen', {}, function(response) {
                if (response.code !== 200) {
                    console.log(response.msg);
                }
            });
        },

        showImagePreview: function(image, name) {
            let obj = document.getElementById('imgpreview');
            if (obj) {
                obj.style.display = 'block';
            }

            let obj2 = document.getElementById('imgpreview-name');
            if (obj2) {
                obj2.innerHTML = name;
            }

            let obj3 = document.getElementById('imgpreview-image');
            if (obj3) {
                obj3.src = window.location.origin + '/gfx/avatars/' + image;
            }
        },

        handleCookieConsent: function () {
            let cookies = document.cookie.split(';');
            let foundCookie = false;
            for (let i = 0; i < cookies.length; i++) {
                if (cookies[i].indexOf('cookieconsent') !== -1) {
                    foundCookie = true;
                    break;
                }
            }

            if (foundCookie === false) {
                document.getElementById('cookie-consent').style.display = 'inline-block';
            }
        },

        clickedCookieConsentButton: function () {
            let expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'cookieconsent=1; expires=' + expDate.toUTCString() + ';';

            document.getElementById('cookie-consent').style.display = 'none';
        },

        loadAd: function(target) {
            if (target !== null) {
                this.ajaxRequest('get', window.location.origin + '/ads/code', {}, function(response) {
                    if (response.code == 200) {
                        target.innerHTML = response.adcode;

                        let tagElems = [];
                        let childNodes = target.childNodes;

                        for (let i = 0; i < childNodes.length; i++) {
                            if (typeof childNodes[i].tagName !== 'undefined') {
                                let childTag = document.createElement(childNodes[i].tagName);
                                let tagCode = document.createTextNode(childNodes[i].innerHTML);
                                childTag.appendChild(tagCode);
                                tagElems.push(childTag);
                            }
                        }

                        target.innerHTML = '';

                        for (let i = 0; i < tagElems.length; i++) {
                            target.appendChild(tagElems[i]);
                        }
                        
                    } else {
                        console.error(response);
                    }
                });
            }
        },

        setClepFlag: function() {
            var expDate = new Date(Date.now() + 1000 * 60 * 60 * 24 * 365);
            document.cookie = 'clep=1; expires=' + expDate.toUTCString() + '; path=/;';
        },
    }
});

document.addEventListener('DOMContentLoaded', function() {
    window.vue.initNavbar();
});