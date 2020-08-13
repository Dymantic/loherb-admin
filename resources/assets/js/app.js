/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import Vue from "vue";
import { VueForm } from "@dymantic/vue-forms";
import { Dropdown, DeleteModal, Toggleswitch } from "@dymantic/vuetilities";
import Modal from "@dymantic/modal";

import UserPage from "./components/Users/UserPage";
import UserForm from "./components/Users/UserForm";
import UsersIndex from "./components/Users/UsersIndex";

import BlogIndex from "./components/Blog/BlogIndex";
import EditorPage from "./components/Blog/EditorPage";
import NewPostForm from "./components/Blog/NewPostForm";

import CategoriesIndex from "./components/Blog/CategoriesIndex";

import CheckFeed from "./components/Instagram/CheckFeed";

Vue.component("dropdown-item", Dropdown);
Vue.component("vue-form", VueForm);
Vue.component("modal", Modal);
Vue.component("delete-modal", DeleteModal);
Vue.component("toggle-switch", Toggleswitch);
Vue.component("user-page", UserPage);
Vue.component("user-form", UserForm);
Vue.component("users-index", UsersIndex);
Vue.component("blog-index", BlogIndex);
Vue.component("new-post-form", NewPostForm);
Vue.component("editor-page", EditorPage);
Vue.component("check-instagram-feed", CheckFeed);
Vue.component("categories-index", CategoriesIndex);

Vue.config.ignoredElements = [
    'trix-editor',
];

const app = new Vue({
    el: "#app"
});
