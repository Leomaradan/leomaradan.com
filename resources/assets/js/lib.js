
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

//window.$ = window.jQuery = require('jquery');
//require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Store = require('store');

window.Vue = require('vue');
require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;

    next();
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

//var alert = require('vue-strap').alert;
//var navbar = require('vue-strap').navbar;

//Vue.component('example', require('./components/Example.vue'));

Vue.component('list-menu', require('./components/List-Menu.vue'));
Vue.component('bootstrap-navmenu', require('./components/Bootstrap-Navmenu.vue'));
Vue.component('blog-posting', require('./components/BlogPosting.vue'));

Vue.component('masonry-box', require('./components/MasonryBox-Post.vue'));

Vue.component('alert', require('vue-strap').alert);
Vue.component('navbar', require('vue-strap').navbar);
