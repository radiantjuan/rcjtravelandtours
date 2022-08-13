import {isLoggedIn, logOut} from "./shared/utils/auth";

export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: []
        },
        isLoggedIn: false,
        user: {}
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        addToBasket(state, payload) {
            state.basket.items.push(payload);
        },
        removeFromBasket(state, payload) {
            state.basket.items = state.basket.items.filter(items => items.bookable.id !== payload);
        },
        setBasket(state, payload) {
            state.basket = payload;
        },
        setUser(state, payload) {
            state.user = payload
        },
        setLoggedIn(state, payload) {
            state.isLoggedIn = payload;
        }
    },
    actions: {
        /**
         * Setting the last search from and to dates
         * @param context
         * @param payload
         */
        setLastSearch(context, payload) {
            localStorage.setItem('lastSearch', JSON.stringify(payload));
            context.commit('setLastSearch', payload);
        },
        /**
         * loading stored state from local storage
         * @param commit
         */
        loadStoredState({commit}) {
            const lastSearch = localStorage.getItem('lastSearch');
            if (lastSearch) {
                commit('setLastSearch', JSON.parse(lastSearch));
            }

            const basket = localStorage.getItem('basket');
            if (basket) {
                commit('setBasket', JSON.parse(basket));
            }

            commit('setLoggedIn', isLoggedIn());
        },
        /**
         * Adding bookings to cart
         * @param commit
         * @param state
         * @param payload
         */
        addToBasket({commit, state}, payload) {
            commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        /**
         * Removing bookings to cart
         * @param commit
         * @param state
         * @param payload
         */
        removeFromBasket({commit, state}, payload) {
            commit('removeFromBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        clearBasket({commit, state}, payload) {
            commit('setBasket', {items: []});
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        loadUser({commit, dispatch}) {
            if (isLoggedIn()) {
                axios.get('/user').then((response) => {
                    commit("setUser", response.data);
                    commit("setLoggedIn", true);
                }).catch((error) => {
                    dispatch('logout');
                });
            }
        },
        logout({commit}) {
            commit('setUser', {});
            commit('setLoggedIn', false);
            logOut();
        }
    },
    getters: {
        itemsInBasket: (state) => state.basket.items.length,
        inBasketAlready: (state) => (id) => state.basket.items.reduce((result, item) => result || item.bookable.id === id, false)
    }
}
