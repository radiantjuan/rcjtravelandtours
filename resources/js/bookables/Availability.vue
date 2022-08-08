<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">Check Availability
            <transition name="fade">
                <span class="text-danger" v-if="hasNoAvailability">(NOT AVAILABLE)</span>
                <span class="text-success" v-if="hasAvailability">(AVAILABLE)</span>
            </transition>
        </h6>
        <div class="form-row">
            <div class="col">
                <label for="from">From</label>
                <input type="date" name="from" class="form-control" :class="[{'is-invalid': this.errorFor('from')}]"
                       placeholder="Start Date" v-model="from"
                       @keyup.enter="check();">
                <v-errors :errors="this.errorFor('from')"></v-errors>
            </div>
            <div class="col">
                <label for="to">To</label>
                <input type="date" name="to" class="form-control" :class="[{'is-invalid': this.errorFor('from')}]"
                       placeholder="End Date" v-model="to"
                       @keyup.enter="check();">
                <v-errors :errors="this.errorFor('to')"></v-errors>
            </div>
        </div>
        <p v-if="loading">processing...</p>
        <button class="btn btn-secondary btn-block btn-md mt-3" @click="check();" :disabled="loading">
            <span v-if="!loading">Check!</span>
            <span v-if="loading"><i class="fas fa-circle-notch fa-spin"></i> Checking...</span>
        </button>
    </div>
</template>
<style scoped>
label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: gray;
    font-weight: bolder;
}
</style>
<script>
import {is404, is422} from "../shared/utils/response";
import validationErrors from "../shared/mixins/validationErrors";

export default {
    mixins: [validationErrors],
    props: {
        bookableId: [String, Number]
    },
    data() {
        return {
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            loading: false,
            status: null,
            errors: null
        }
    },
    methods: {
        /**
         * Checking booking availability in the backend
         */
        check() {
            this.loading = true;
            this.errors = null;

            //global state
            this.$store.dispatch('setLastSearch', {
                from: this.from,
                to: this.to
            })

            axios.get(`/api/bookable/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)
                .then((res) => {
                    this.status = res.status;
                    this.$emit('availability', this.hasAvailability);
                })
                .catch((err) => {
                    if (is422(err)) {
                        this.errors = err.response.data.errors;
                    }
                    this.status = err.response.status;
                    this.$emit('availability', this.hasAvailability);
                })
                .then(() => {
                    this.loading = false;
                });
        }
    },
    computed: {
        /**
         * Checking if the returned response has errors
         * @returns {boolean}
         */
        hasErrors() {
            return 422 === this.status && this.errors !== null
        },
        /**
         * Checking if the returned response is success
         * @returns {boolean}
         */
        hasAvailability() {
            return 200 === this.status;
        },
        /**
         * The returned response has the right data
         * if the status is 404, it means the database didn't get any record
         * the backend is forcing it to have a 404 not found
         * @returns {boolean}
         */
        hasNoAvailability() {
            return 404 === this.status;
        }
    }
}
</script>
