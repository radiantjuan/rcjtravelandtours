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
        setLastSearch(context, payload) {
            localStorage.setItem('lastSearch', JSON.stringify(payload));
            context.commit('setLastSearch', payload);
        },
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
        addToBasket({commit, state}, payload) {
            commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
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
