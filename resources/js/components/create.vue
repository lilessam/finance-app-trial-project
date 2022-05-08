<template>
    <div class="flex flex-wrap -mx-3 mb-2">
        <!-- @TODO: Might not be the best approach to manipulate the component properties -->
        <label-input :form="form" :errors="errors"></label-input>
        <date-input :form="form" :errors="errors"></date-input>
        <amount-input :form="form" :errors="errors"></amount-input>
        <div class="flex items-center p-6 space-x-2 rounded-b">
            <button @click="$emit('close')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
            <button @click="save()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </div>
    </div>
</template>
<script>
import labelInput from './form/label-input.vue'
import dateInput from './form/date-input.vue'
import amountInput from './form/amount-input.vue'
export default {
    components: {
        'label-input': labelInput,
        'date-input': dateInput,
        'amount-input': amountInput,
    },
    data() {
        return {
            form: {
                label: null,
                amount_date: null,
                amount: null
            }
        }
    },
    provide() {
        return {
            $validator: this.$validator,
        }
    },
    methods: {
        async save() {
            if (await this.formHasErrors()) return;
            var app = this;
            this.$transactions.store(this.form).then(response => {
                app.$emit('done');
            }).catch(error => {
                // @TODO: We might consider adding backend validation.
            });
        }
    }
}
</script>
