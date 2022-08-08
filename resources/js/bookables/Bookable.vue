<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <p v-if="book_info.title">{{ book_info.title }}</p>
                    </div>
                    <div class="card-body">
                        <p v-if="book_info.description">{{ book_info.description }}</p>
                    </div>
                </div>
                <review-list :bookable-id="this.$route.params.id"/>
            </div>
            <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                <availability
                    :bookable-id="this.$route.params.id"
                    @availability="checkPrice($event)"
                    class="mb-4"
                />
                <transition name="fade">
                    <price-breakdown v-if="price" :price="price" class="pb-3"/>
                </transition>
                <transition name="fade">
                    <button class="btn btn-outline-secondary btn-block" v-if="price" @click="addToBasket"
                            :disabled="inBasketAlready">
                        Book Now
                    </button>
                </transition>
                <button class="btn btn-outline-secondary btn-block" v-if="inBasketAlready" @click="removeFromBasket">
                    Remove from basket
                </button>
                <div v-if="inBasketAlready" class="mt-4 text-muted warning">Seems like you've added this object
                    already.
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Availability from './Availability';
import ReviewList from './ReviewList';
import {mapState} from "vuex";
import PriceBreakdown from './PriceBreakdown';

export default {
    components: {
        Availability,
        ReviewList,
        PriceBreakdown
    },
    data() {
        return {
            book_info: {},
            price: null
        }
    },
    created() {
        const bookable_id = this.$route.params.id;
        axios.get(`/api/booklist/${bookable_id}`).then((res) => this.book_info = res.data);
    },
    computed: {
        ...mapState({
            lastSearch: 'lastSearch'
        }),
        /**
         * Checking if the item is in basket already from global state
         * @returns {boolean|*}
         */
        inBasketAlready() {
            if (null === this.book_info) {
                return false
            }

            return this.$store.getters.inBasketAlready(this.book_info.id);
        }
    },
    methods: {
        /**
         * Check the price stored in the backend
         * @param hasAvailability
         */
        checkPrice(hasAvailability) {
            if (!hasAvailability) {
                this.price = null;
                return;
            }

            // try {
            //
            //     this.price = (await axios.get(`/api/bookable/${this.book_info.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;
            // } catch (err) {
            //     this.price = null;
            // }

            axios.get(`/api/bookable/${this.book_info.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)
                .then((response) => {
                    this.price = response.data.data;
                })
                .catch(err => {
                    this.price = null;
                });
        },
        addToBasket() {
            this.$store.dispatch('addToBasket', {
                bookable: this.book_info,
                price: this.price,
                dates: this.lastSearch
            });
        },
        removeFromBasket() {
            this.$store.dispatch('removeFromBasket', this.book_info.id);
        }
    }
}
</script>
<style scoped>
.warning {
    font-size: 0.7rem;
}
</style>
