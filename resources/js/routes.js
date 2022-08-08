import Bookables from './bookables/Bookables';
import Bookable from "./bookables/Bookable";
import Review from "./review/Review";
import Basket from './basket/Basket';
import VueRouter from "vue-router";

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
    }
]

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;
