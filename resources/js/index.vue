<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
            <router-link v-bind:to="{ name: 'bookables' }" class="navbar-brand mr-auto">RCJ Hotel Travel</router-link>
            <router-link class="btn nav-button" :to="{name: 'home'}">
                <i class="fa fa-cart-plus"></i>
                <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
            </router-link>
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
            lastSearchComputed: 'lastSearch'
        }),
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        })
    }
}
</script>
