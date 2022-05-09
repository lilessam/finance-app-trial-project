<template>
	<div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
		<div class="md:flex">
			<div class="w-full">
				<div class="p-4 border-b-2">
					<span class="text-lg font-bold text-gray-600">Import Balance Entries</span>
				</div>
				<div class="p-3">
					<div class="mb-2">
						<span>.CSV File</span>
						<input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file"
                        ref="importFile"
                        @change="handleFileUpload()">
					</div>
					<div class="mt-3 text-center pb-3">
						<button @click="uploadFile()" class="w-full h-12 text-lg w-32 bg-blue-600 rounded text-white hover:bg-blue-700">Import</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
    data() {
        return {
            importFile: null,
        }
    },
    methods: {
        handleFileUpload() {
            this.importFile = this.$refs.importFile.files[0];
        },
        uploadFile() {
            var app = this
            this.$transactions.uploadImport(this.importFile).then(response => {
                //
                app.$bus.$emit('importRunning', true, response.data.data)
            })
        }
    }
}
</script>
