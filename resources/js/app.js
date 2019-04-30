
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.events = new Vue();

window.noty = function(notification, type){
  window.events.$emit('notification', notification, type);
}

import Lang from 'lang.js';

const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;
const messages = window.messages;

Vue.prototype.trans = new Lang({
  messages,
  locale: default_locale,
  fallback: fallback_locale
});

import Gate from './Gate'
Vue.prototype.$gate = new Gate(window.user);

import BlockUI from 'vue-blockui'
 
Vue.use(BlockUI);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// users
Vue.component('admin-users-index', require('./components/admin/users/Index.vue').default);

// companies
Vue.component('admin-companies-index', require('./components/admin/companies/Index.vue').default);

// paginsation
Vue.component('pagination', require('laravel-vue-pagination'));

// notification
Vue.component('vue-noty', require('./components/Noty.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.directive('select2', {
  twoWay: true,
  bind: function (el, binding, vnode) {
    $(el).select2().on("select2:select", (e) => {
      el.dispatchEvent(new Event('change', { target: e.target }));
    });
  },
});

Vue.directive('datepicker', {
  twoWay: true,
  bind: function (el, binding, vnode) {
    $(el).datepicker().on("changeDate", (e) => {
      el.dispatchEvent(new Event('input', { target: e.target }));
    });
  },
});

const app = new Vue({
    el: '#app'
});

