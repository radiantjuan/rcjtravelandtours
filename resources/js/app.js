require('./bootstrap');
import router from "./routes";
import VueRouter from 'vue-router';
import Index from "./index";
import moment from 'moment';
import StarRating from './shared/components/StarRating';
import FatalError from './shared/components/FatalError';
import ValidationError from "./shared/components/ValidationError";
import Success from './shared/components/Success';

window.Vue = require('vue');
Vue.use(VueRouter);
Vue.filter("fromNow", (value) => moment(value).fromNow());
Vue.component("star-rating", StarRating);
Vue.component("fata-error", FatalError);
Vue.component("success", Success);
Vue.component("v-errors", ValidationError);

const app = new Vue({
    el: '#app',
    router: router,
    components: {
        "index": Index
    }
});
