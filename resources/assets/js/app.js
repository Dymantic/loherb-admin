
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";
import {VueForm} from "@dymantic/vue-forms";
import {Dropdown, Modal, DeleteModal, Toggleswitch} from "@dymantic/vuetilities";
import UserPage from "./components/UserPage";
import UserForm from "./components/UserForm";
import UsersIndex from "./components/UsersIndex";

Vue.component('dropdown-item', Dropdown);
Vue.component('vue-form', VueForm);
Vue.component('modal', Modal);
Vue.component('delete-modal', DeleteModal);
Vue.component('toggle-switch', Toggleswitch);
Vue.component('user-page', UserPage);
Vue.component('user-form', UserForm);
Vue.component('users-index', UsersIndex);



const app = new Vue({
    el: '#app'
});
