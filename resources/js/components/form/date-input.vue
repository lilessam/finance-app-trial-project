<template>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-date">
            Date
        </label>
        <input v-model="form.amount_date" v-validate="'required'" name="amount_date" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-date" type="datetime-local" placeholder="Date">
        <span class="text-rose-600">{{ errors.first('amount_date') }}</span>
    </div>
</template>
<script>
export default {
    props: ['form'],
    inject: ['$validator']
}
</script>
