<template>
<div>
    <div @mouseover="showActions = transaction.id" @mouseleave="showActions = false"
        :class="{ 'flex' : true, 'items-center' : true, 'px-4' : true, 'py-2' : true, 'bg-white' : true, 'shadow-md' : showEdit != transaction.id, 'rounded-md' : showEdit != transaction.id, 'mb-4' : showEdit != transaction.id }">
        <div class="flex-grow">
            <div class="font-bold">
                {{ transaction.label }}
            </div>
            <div class="text-xs text-gray-500">
                {{ transaction.transaction_readable_date }}
            </div>
        </div>
        <div class="flex flex-row mr-10" v-if="showActions == transaction.id && showEdit == false">
            <span @click="displayEditForm()" class="cursor-pointer">Edit</span>
            &nbsp;&nbsp; | &nbsp;&nbsp;
            <span @click="destroy(transaction.id)" class="cursor-pointer">Delete</span>
        </div>
        <div :class="{'text-lg': true, 'font-bold': true, 'text-green-500': transaction.amount_type == '-' ? false : true}">
            {{ transaction.amount_type }} ${{ transaction.amount_integer }}.<span class="text-sm">{{ transaction.amount_decimals }}</span>
        </div>
    </div>
    <div v-if="showEdit == transaction.id" class="flex items-center mb-4 px-4 py-2 shadow-md bg-white rounded-br-lg rounded-bl-lg border-solid border-t">
        <div class="flex flex-wrap -mx-3 mb-2">
            <!-- @TODO: Might not be the best approach to manipulate the component properties -->
            <label-input :form="form"></label-input>
            <date-input :form="form"></date-input>
            <amount-input :form="form"></amount-input>
            <div class="flex items-center p-6 space-x-2 rounded-b">
                <button @click="cancelEditForm()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                <button @click="save()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update Entry</button>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import labelInput from './form/label-input.vue'
import dateInput from './form/date-input.vue'
import amountInput from './form/amount-input.vue'
export default {
    props: ['transaction'],
    components: {
        'label-input': labelInput,
        'date-input': dateInput,
        'amount-input': amountInput,
    },
    provide() {
        return {
            $validator: this.$validator,
        }
    },
    data() {
        return {
            showActions: false,
            showEdit: false,
            form: {
                label: null,
                amount_date: null,
                amount: null
            }
        }
    },
    methods: {
        destroy(id) {
            var app = this
            this.$transactions.destroy(id).then(response => {
                app.$bus.$emit('refrshTransactions')
            })
        },
        displayEditForm() {
            this.showEdit = this.transaction.id
            for (var attribute in this.form) {
                if (attribute == 'amount_date') {
                    this.form[attribute] = this.transaction.amount_date_time
                } else {
                    this.form[attribute] = this.transaction[attribute]
                }
            }
        },
        cancelEditForm() {
            this.showEdit = false
            for (var attribute in this.form) {
                this.form[attribute] = null
            }
        },
        async save() {
            if (await this.formHasErrors()) return;
            var app = this;
            this.$transactions.update(this.transaction.id, this.form).then(response => {
                app.$bus.$emit('refrshTransactions')
                app.cancelEditForm()
            }).catch(error => {
                // @TODO: We might consider adding backend validation.
            });
        }
    }
}
</script>