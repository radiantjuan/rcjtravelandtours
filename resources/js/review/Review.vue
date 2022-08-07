<template>
    <div class="container">
        <fatal-error v-if="error"/>
        <success v-if="success" />
        <div v-else class="row">
            <div :class="[{'col-md-4': twoCol},{'d-none': oneCol}]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading...</div>
                        <div v-if="hasBooking">
                            <p>
                                Stayed at
                                <router-link :to="{name: 'bookable', params: {id: booking.bookable.id} }">{{
                                        booking.bookable.title
                                    }}
                                </router-link>
                            </p>
                            <p>
                                From {{ booking.from }} to {{ booking.to }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'col-md-8': twoCol},{'col-md-12': oneCol}]">
                <div v-if="loading">loading...</div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        <h3>You've already left a review for this booking!</h3>
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <p class="text-muted d-block">Select the star rating (1 is worst - 5 is best)</p>
                            <div>
                                <star-rating class="d-flex fa-3x py-4" v-model="review.rating"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="text-muted">Describe your experience with</label>
                            <textarea name="content"
                                      cols="30"
                                      rows="10"
                                      class="form-control"
                                      v-model="review.content"
                                      :class="[{'is-invalid': this.errorFor('content')}]"></textarea>
                            <v-errors :errors="this.errorFor('content')"></v-errors>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" @click.prevent="submit"
                                :class="[{'disabled':sending}]">Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {is404, is422} from "../shared/utils/response";
import FatalError from "../shared/components/FatalError";
import validationErrors from '../shared/mixins/validationErrors';

export default {
    mixins: [validationErrors],
    components: {FatalError},
    data() {
        return {
            loading: false,
            review: {
                id: null,
                rating: 5,
                content: null
            },
            existingReview: null,
            booking: null,
            error: false,
            errors: null,
            sending: false,
            success: false
        }
    },
    async created() {
        this.review.id = this.$route.params.id;
        this.loading = true;
        try {
            this.existingReview = (await axios.get(`/api/reviews/${this.$route.params.id}`)).data.data;
        } catch (err) {
            if (is404(err)) {
                try {
                    this.booking = (await axios.get(`/api/booking-by-review/${this.review.id}`)).data.data
                } catch(err) {
                    if (!is404(err)) {
                        this.error = true;
                    }
                }
            } else {
                this.error = true;
            }
        }
        this.loading = false;

        //
        // axios.get(`/api/reviews/${this.$route.params.id}`)
        //     .then(response => (this.existingReview = response.data.data))
        //     .catch((err) => {
        //         if (is404(err)) {
        //             return axios.get(`/api/booking-by-review/${this.review.id}`).then(response => {
        //                 this.booking = response.data.data
        //             }).catch((err) => {
        //                 if (!is404(err)) {
        //                     this.error = true;
        //                 }
        //             });
        //         }
        //
        //         this.error = true;
        //     })
        //     .then(() => this.loading = false);
    },
    computed: {
        alreadyReviewed() {
            return this.hasReview || !this.booking;
        },
        hasReview() {
            return this.existingReview != null;
        },
        hasBooking() {
            return this.booking != null;
        },
        oneCol() {
            return !this.loading && this.alreadyReviewed
        },
        twoCol() {
            return this.loading || !this.alreadyReviewed
        }
    },
    methods: {
        submit() {
            this.sending = true;
            axios.post('/api/reviews', this.review)
                .then(response => {
                    this.success = 201 === response.status;
                })
                .catch(err => {
                    if (is422(err)) {
                        const errors = err.response.data.errors;
                        if (errors['content'] && 1 === _.size(errors)) {
                            this.errors = errors;
                            return;
                        }
                    }
                    this.error = true;
                })
                .then(() => {
                    this.loading = false
                    this.sending = false;
                });
        },
    }
}
</script>
