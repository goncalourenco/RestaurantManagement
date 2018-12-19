/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import store from './stores/global-store';
import VueRouter from "vue-router";
Vue.use(VueRouter);
import Vuetify from "vuetify";
Vue.use(Vuetify);
import "vuetify/dist/vuetify.min.css";

import menuToolbar from './components/toolbar.vue';

const item = Vue.component("item", require("./components/items/item.vue"));
const worker = Vue.component("worker", require("./components/worker/worker.vue"));
const login = Vue.component("login", require("./components/auth/login.vue"));
const logout = Vue.component("logout", require("./components/auth/logout.vue"));
const userDashboard = Vue.component("userDashboard", require("./components/worker/dashboard.vue"));

const routes = [{
        path: "/items",
        component: item,
        name: "items"
    },
    {
        path: '/',
        redirect: '/items',
        name: "root"
    },
    {
        path: "/worker",
        component: worker,
        name: "worker"
    },
    {
        path: "/login",
        component: login,
        name: "login"
    },
    {
        path: "/logout",
        component: logout,
        name: "logout"
    },
    {
        path: "/dashboard",
        component: userDashboard,
        name: "dashboard"
    }
];

const router = new VueRouter({
    routes: routes,
});

router.beforeEach((to, from, next) => {
    if (((to.name != "items" || to.name != "root") && sessionStorage.getItem('user') == null) && to.name != "login") {
        next("/login");
    }
    next();
});

window.Vue = require("vue");
const app = new Vue({
    el: "#app",
    data() {
        return {
            title: "Restaurant Management",
            items: [{
                    name: "My profile",
                    icon: "home",
                    link: "/worker"
                },
                {
                    name: "Logout",
                    icon: "logout",
                    link: "/logout"
                }
            ]
        }
    },
    router,
    store,
    created() {
        this.$store.commit('loadTokenAndUserFromSession');
    },
    components: {
        'menu-toolbar': menuToolbar
    },
    methods: {
        logout() {
            this.showMessage = false;
            axios
                .post("api/logout")
                .then(response => {
                    this.$store.commit("clearUserAndToken");
                })
                .catch(error => {
                    this.$store.commit("clearUserAndToken");
                    console.log(error);
                });
        },
        route(path) {
            this.$router.push({
                path: "/items"
            });
        }
    },

});
