<template>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-amount">
            Amount
        </label>
        <input v-model="form.amount" v-validate="'required'" name="amount" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-amount" type="number" placeholder="1.00">
        <span class="text-rose-600">{{ errors.first('amount') }}</span>
    </div>
</template>
<script>
export default {
    props: ['form'],
    inject: ['$validator']
}
</script>
