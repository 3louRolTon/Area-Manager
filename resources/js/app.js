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
// Create models
Vue.component('area-create-template', () => import("./components/user/create/AreaCreate.vue"))
Vue.component('district-create-template', () => import("./components/user/create/DistrictCreate.vue"))
Vue.component('city-create-template', () => import("./components/user/create/CityCreate.vue"))
Vue.component('street-create-template', () => import("./components/user/create/StreetCreate.vue"))
Vue.component('house-create-template', () => import("./components/user/create/HouseCreate.vue"))
Vue.component('spot-create-template', () => import("./components/user/create/SpotCreate.vue"))

// Update models
Vue.component('area-update-template', () => import("./components/user/update/AreaUpdate.vue"))
Vue.component('district-update-template', () => import("./components/user/update/DistrictUpdate.vue"))
Vue.component('city-update-template', () => import("./components/user/update/CityUpdate.vue"))
Vue.component('street-update-template', () => import("./components/user/update/StreetUpdate.vue"))
Vue.component('house-update-template', () => import("./components/user/update/HouseUpdate.vue"))
Vue.component('spot-update-template', () => import("./components/user/update/SpotUpdate.vue"))

Vue.component('bind-template', () => import("./components/user/address/Bind.vue"))
Vue.component('unbind-template', () => import("./components/user/address/UnBind.vue"))
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
