<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-white border-bottom navbar-light">
            <router-link v-bind:to="{ name: 'bookables' }" class="navbar-brand mr-auto">RCJ Hotel Travel</router-link>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{name: 'basket'}">
                        <i class="fa fa-cart-plus"></i>
                        <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link class="nav-link" :to="{name: 'register'}">
                        Register
                    </router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link class="nav-link" :to="{name: 'login'}">
                        Sign In
                    </router-link>
                </li>

                <li class="nav-item" v-if="isLoggedIn">
                    <a class="nav-link" href="#" @click="logout()">Logout</a>
                </li>
            </ul>
        </nav>
        <div class="container mt-4 mb-4 pr-4 pl-4"></div>
        <router-view></router-view>
    </div>
</template>
<script>
import {mapState, mapGetters} from 'vuex';

export default {
    data() {
        return {
            lastSearch: this.$store.state.lastSearch
        }
    },
    computed: {
        ...mapState({
            lastSearchComputed: 'lastSearch',
            isLoggedIn: "isLoggedIn"
        }),
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        })
    },
    methods: {
        logout() {
            axios.post('/logout').catch((error) => {
                this.$store.dispatch('logout');
            });
            this.$store.dispatch('logout');
        }
    }
}
</script>
