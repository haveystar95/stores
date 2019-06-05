require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate'
// import {routes} from './routes.js';
import storeData from './store.js';
import App from './components/App.vue';
import router   from './routes';
import {http, api}                  from './assets/http';



Vue.use(VeeValidate);
// Vue.use(VueRouter);
Vue.use(Vuex);
Vue.prototype.$http = http;
Vue.prototype.$api = api;

const store = new Vuex.Store(storeData);

const app = new Vue({
    router,
    store,
    template: '<app></app>',
    components: {
    App
}
}).$mount('#app');
