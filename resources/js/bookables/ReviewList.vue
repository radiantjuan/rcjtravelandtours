<template>
    <div style="padding: 1.25rem">
        <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">Review List</h6>
        <div v-if="loading">loading...</div>
        <div v-else>
            <div class="border-bottom d-none d-md-block" v-for="(review, index) in reviews" :key="index">
                <div class="row pt-4">
                    <div class="col-md-6">
                        Radiant Juan
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <star-rating :value="review.rating" class="d-flex"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ review.created_at | fromNow }}</div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12">{{ review.content }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        bookableId: [String, Number]
    },
    data() {
        return {
            loading: false,
            reviews: null
        }
    },
    created() {
        this.loading = true;
        axios.get(`/api/bookable/${this.bookableId}/reviews`)
            .then((response) => {
                this.reviews = response.data.data
            })
            .finally(() => {
                this.loading = false;
            });
    },
    // filters: {
    //     changeRating(value) {
    //         const added = value + (value < 5 ? Math.random(0.1, 0.9) : 0);
    //         return added;
    //     }
    // }
}
</script>
