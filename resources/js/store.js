export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: []
        }
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
        }
    },
    getters: {
        itemsInBasket: (state) => state.basket.items.length,
        inBasketAlready: (state) => (id) => state.basket.items.reduce((result, item) => result || item.bookable.id === id, false)
    }
}
