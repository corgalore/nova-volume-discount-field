<template>
    <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
        <template slot="field">
            <table cellpadding="0" cellspacing="0" class="table w-full table-default">
                <thead>
                    <tr>
                       <th>
                           <span>{{ headingQty }}</span>
                       </th>
                        <th v-for="tier in tiers">
                            <input type="text" class="text-center bg-transparent" style="max-width:100px" v-model="tier.label">
                            <template v-if="tier.index > 0">
                                <button type="button" @click="removeTier(tier)">
                                    <icon type="delete" class="text-80 h-3 align-bottom" />
                                </button>
                            </template>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows">
                        <td class="text-center"><input type="text" class="text-center w-10" v-model="row.qty"></td>
                        <td class="text-center" v-for="tier in tiers" key="tier">
                            <input type="text" class="text-center w-10" v-model="row.discounts[tier.index]"> {{discountSuffix}}
                        </td>
                        <td>
                            <button type="button" @click="removeDiscount(row)">
                                <icon type="delete" class="text-80" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <span v-if="rows.length==0">No Discounts</span>
            <div class="mt-3 text-right">
                <button type="button"
                        class="btn btn-default btn-primary inline-flex items-center relative mr-2"
                        @click="addTier"
                        v-if="this.tiers.length < this.maxTiers">Add Tier</button>
                <button type="button" class="btn btn-default btn-primary inline-flex items-center relative" @click="addDiscount">Add Discount</button>
            </div>

            <input
                :id="field.name"
                type="hidden"
                :class="errorClasses"
                :placeholder="field.name"
                v-model="value"
            />

        </template>
    </default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [ FormField, HandlesValidationErrors ],

    props: [ 'resourceName', 'resourceId', 'field' ],

    data() {
        return { heading: '', rows: [], tiers: [] }
    },

    watch: {
        rows: {
            handler(val){
                this.value = JSON.stringify( {
                    tiers: this.tiers,
                    rows: this.rows
                } );
            },
            deep: true
        },
        tiers: {
            handler(val){
                this.value = JSON.stringify( {
                    tiers: this.tiers,
                    rows: this.rows
                } );
            },
            deep: true
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {},

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill( formData ) {
            formData.append( this.field.attribute, this.value || '' )
        },

        addTier() {

            if ( this.tiers.length >= this.maxTiers ){
                return;
            }

            this.tiers.push( { index: this.tiers.length, label: this.headingDiscount + (this.tiers.length + 1) } );

            this.rows.forEach((row) => {

                let val = '';

                for ( const tier of this.tiers ) {
                    if ( row.discounts[tier.index] !== '' && row.discounts[tier.index] !== undefined ){
                        val = row.discounts[tier.index];
                    }

                    if ( row.discounts[tier.index] === undefined ||
                        row.discounts[tier.index] === '0' ||
                        row.discounts[tier.index] === '' ) {

                        row.discounts[ tier.index ] = val;
                    }
                }
            });
        },

        removeTier(tier) {

            const idx = this.tiers.indexOf(tier);

            this.tiers.splice(idx, 1);

            this.rows.forEach((row) => {
                row.discounts.splice(idx, 1);
            })
        },

        addDiscount() {
            let row = { qty: 0, discounts: [] };

            for ( const tier of this.tiers ) {
                row.discounts[tier.index] = 0;
            }

            this.rows.push(row);
        },

        removeDiscount(row) {
            this.rows.splice(this.rows.indexOf(row), 1);
        }
    },

    mounted() {
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

        if ( Object.keys( storedValue).length > 0 )
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
