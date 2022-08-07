<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">Check Availability <span
            :class="[{'text-success': hasAvailability, 'text-danger':hasNoAvailability}]">{{
                hasAvailability ? '(AVAILABLE)' : ''
            }}{{ hasNoAvailability ? '(NOT AVAILABLE)' : '' }}</span>
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
        <button class="btn btn-secondary btn-block btn-md mt-3" @click="check();" :disabled="loading">Check!</button>
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
      bookableId: String
    },
    data() {
        return {
            from: null,
            to: null,
            loading: false,
            status: null,
            errors: null
        }
    },
    methods: {
        check() {
            this.loading = true;
            axios.get(`/api/bookable/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)
                .then((res) => {
                    this.status = res.status;
                })
                .catch((err) => {
                    if (is422(err)) {
                        this.errors = err.response.data.errors;
                    }
                    this.status = err.response.status;
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },
    computed: {
        hasErrors() {
            return 422 === this.status && this.errors !== null
        },
        hasAvailability() {
            return 200 === this.status;
        },
        hasNoAvailability() {
            return 404 === this.status;
        }
    }
}
</script>
