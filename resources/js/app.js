/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue').default;

import VueSidebarMenu from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';
import 'vue-search-select/dist/VueSearchSelect.css';
require('./bootstrap');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(VueSidebarMenu)

// Admin Template
Vue.component('admin-side-bar', () => import("./components/AdminSideBar.vue"))
Vue.component('user-side-bar', () => import("./components/UserSideBar.vue"))
Vue.component('register', () => import("./components/Admin/Register.vue"))

// User Template

Vue.component('area-create-template', () => import("./components/user/AreaCreate.vue"))
Vue.component('district-create-template', () => import("./components/user/DistrictCreate.vue"))
Vue.component('city-create-template', () => import("./components/user/CityCreate.vue"))

//Vue.component('select-test', () => import("./components/TestSelect.vue"))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components:{
        loader:loader
    }
});