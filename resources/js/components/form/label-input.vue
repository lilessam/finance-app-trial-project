<template>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-label">
            Label
        </label>
        <input v-model="form.label" v-validate="'required'" name="label" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-label" type="text" placeholder="Lorem Ipsum">
        <span class="text-rose-600">{{ errors.first('label') }}</span>
    </div>
</template>
<script>
export default {
    props: ['form'],
    inject: ['$validator']
}
</script>
