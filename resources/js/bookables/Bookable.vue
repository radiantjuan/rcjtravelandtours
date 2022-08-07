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
                <availability :bookable-id="this.$route.params.id"/>
            </div>
        </div>
    </div>
</template>
<script>
import Availability from './Availability';
import ReviewList from './ReviewList';

export default {
    components: {
        Availability,
        ReviewList
    },
    data() {
        return {
            book_info: {}
        }
    },
    mounted() {
        const bookable_id = this.$route.params.id;
        axios.get(`/api/booklist/${bookable_id}`).then((res) => this.book_info = res.data);
    }
}
</script>
