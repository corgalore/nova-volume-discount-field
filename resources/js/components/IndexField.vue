<template>
    <div>
        <span v-if="hasDiscounts">{{ discounts }} Discount(s)</span>
        <span v-else>No Discounts</span>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data(){
      return {
          discounts: 0,
          hasDiscounts: false
      }
    },
    created(){
        const storedValue = JSON.parse( this.field.value || '{ "tiers":[],"rows":[] }' );

        if ( storedValue.length < 1 )
            return;

        if ( storedValue.rows ) {
            this.rows = storedValue.rows;
        }
        this.discounts = this.rows.length;
        this.hasDiscounts = this.discounts > 0;
    }
}
</script>
