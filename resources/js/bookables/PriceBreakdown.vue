<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">Price Breakdown</h6>
        <div v-for="(days, price) in price.breakdown" :key="price" class="pt-2 pb-2 border-bottom border-top container-fluid">
            <div class="row">
                <div class="col">
                    {{days}} x ${{price}}
                </div>
                <div class="col text-right">
                    = ${{days * price}}
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="font-weight-bolder text-right">Total ${{ price.total }}</div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        price: Object
    }
}
</script>
