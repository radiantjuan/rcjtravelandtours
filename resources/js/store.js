export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        }
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        }
    },
    actions: {
        setLastSearch(context, payload) {
            localStorage.setItem('lastSearch', JSON.stringify(payload));
            context.commit('setLastSearch', payload);
        },
        loadStoredState(context) {
            const lastSearch = localStorage.getItem('lastSearch');
            if (lastSearch) {
                context.commit('setLastSearch', JSON.parse(lastSearch));
            }
        }
    }
}
