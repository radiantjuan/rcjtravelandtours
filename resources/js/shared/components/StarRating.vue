<template>
    <div>
        <i class="fas fa-star fa-lg" v-for="(stars, index) in fullStars" :key="'full'+index" @click="$emit('input', stars)"></i>
        <i class="fas fa-star-half-alt fa-lg" v-if="halfStar"></i>
        <i class="far fa-star fa-lg" v-for="(stars, index) in emptyStars" :key="'empty'+index" @click="$emit('input', fullStars + stars)"></i>
    </div>
</template>
<script>
export default {
    props: {
        value: Number
    },
    computed: {
        halfStar() {
            const fraction = Math.round((this.value - Math.floor(this.value)) * 100);
            return fraction > 0 && fraction < 50;
        },
        fullStars() {
            return Math.round(this.value);
        },
        emptyStars() {
            return 5 - Math.ceil(this.value);
        }
    }
}
</script>
