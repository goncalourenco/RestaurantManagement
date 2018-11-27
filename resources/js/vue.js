require('./bootstrap');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const item = Vue.component('item', require('./components/item.vue'));

const routes = [{
    path: '/items',
    component: item
}]

const router = new VueRouter({
    routes: routes
});

window.Vue = require('vue');
const app = new Vue({
    el: '#app',
    data: {
        title: "Restaurant Management"
    },
    router,
});
