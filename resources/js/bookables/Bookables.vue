<template>
    <div class="container">
        <div class="row justify-content-start">
            <BookableListItem v-for="(bookslist, index) in books" v-bind="bookslist" :key="index" :price="1000">/
            </BookableListItem>
        </div>
    </div>
</template>

<script>
import BookableListItem from './BookableListItem'
export default {
    data() {
        return {
            books: null
        }
    },
    mounted() {
        axios.get('/api/booklist').then((res) => {
            this.books = res.data.data;
        }).catch((err) => {
            console.log(err);
        });
    },
    components: {
        BookableListItem: BookableListItem,
    }
}
</script>
