<template>
    <panel-item :field="field">
        <template slot="value">
            <table cellpadding="0" cellspacing="0" class="table w-full table-default">
                <thead>
                <tr>
                    <th>
                        <span>{{ headingQty }}</span>
                    </th>
                    <th v-for="tier in tiers">
                        <span>{{tier.label}}</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in rows">
                    <td class="text-center"><input type="text" class="text-center w-10" v-model="row.qty"></td>
                    <td class="text-center" v-for="tier in tiers" key="tier">
                        <span>{{row.discounts[tier.index]}} {{discountSuffix}}</span>
                    </td>
                </tr>
                </tbody>
            </table>
            <span v-if="rows.length==0">No Discounts</span>
        </template>
    </panel-item>
</template>

<script>
export default {
    props: [ 'resource', 'resourceName', 'resourceId', 'field' ],

    data() {
        return { heading: '', rows: [], tiers: [] }
    },

    created() {
        this.headingQty = this.field.headingQty || 'Qty';
        this.headingDiscount = this.field.headingDiscount || 'Discount';
        this.discountSuffix = this.field.discountSuffix || '%';
        this.maxTiers = this.field.maxTiers || -1;
        this.tiers = [];
        this.rows = [];

        if ( undefined === this.field.tiers ){
            this.field.tiers = [];
        }

        const storedValue = JSON.parse( this.field.value || '{ "tiers":[],"rows":[] }' );

        if ( Object.keys( storedValue ).length > 0 )
        {
            if ( storedValue.tiers ) {
                this.tiers = storedValue.tiers;
            }
            if ( storedValue.rows ) {
                this.rows = storedValue.rows;
            }
        }

        if ( this.tiers.length < 1 && this.field.tiers.length > 0 ){
            this.field.tiers.push( this.headingDiscount );

            this.field.tiers.forEach((tier, idx) => {
                this.tiers.push( { index: idx, label: tier } );
            });
        }
    }

}
</script>
