require('./bootstrap');
import router from "./routes";
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import Index from "./index";
import moment from 'moment';
import StarRating from './shared/components/StarRating';
import FatalError from './shared/components/FatalError';
import ValidationError from "./shared/components/ValidationError";
import Success from './shared/components/Success';
import storeDefinition from './store';


window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.filter("fromNow", (value) => moment(value).fromNow());
Vue.component("star-rating", StarRating);
Vue.component("fata-error", FatalError);
Vue.component("success", Success);
Vue.component("v-errors", ValidationError);

const store = new Vuex.Store(storeDefinition);
const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "index": Index
    },
    beforeCreate() {
        store.dispatch('loadStoredState');
    }
});
