import Bookables from './bookables/Bookables';
import Bookable from "./bookables/Bookable";
import Review from "./review/Review";
import Basket from './basket/Basket';
import VueRouter from "vue-router";
import Register from "./auth/Register";

/**
 * routes vue JS
 */
const routes = [
    {
        path: "/",
        name: "bookables",
        component: Bookables
    },
    {
        path: "/bookable/:id",
        name: "bookable",
        component: Bookable
    },
    {
        path: "/review/:id",
        name: "bookable",
        component: Review
    },
    {
        path: "/basket",
        name: "basket",
        component: Basket
    },
    {
        path: "/auth/login",
        name: "login",
        component: require('./auth/Login').default
    },
    {
        path: "/auth/register",
        name: "register",
        component: Register
    }
]

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;
