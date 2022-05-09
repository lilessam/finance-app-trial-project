<template>
<div>
    <div class="mb-12 py-6 bg-gray-800">
        <vue-tailwind-modal
            :showing="showCreateModal"
            @close="showCreateModal = false"
            :showClose="true"
            :backgroundClose="true"
        >
            <create @close="showCreateModal = false" @done="transactionCreated()"></create>
        </vue-tailwind-modal>

        <vue-tailwind-modal
            :showing="showImportModal"
            @close="showImportModal = false"
            :showClose="true"
            :backgroundClose="true"
        >
            <import @close="showImportModal = false"></import>
        </vue-tailwind-modal>
        <div class="container mx-auto flex px-8">
            <div class="my-auto text-white flex flex-grow items-center">
                <h1 class="md:block hidden mr-4 text-2xl font-bold">
                    Your Balance
                </h1>

                <div class="flex flex-row">
                    <a @click="!importRunning ? showCreateModal = true : null" class="cursor-pointer flex items-center mr-4 px-3 py-2 bg-blue-700 rounded-md text-white text-xs font-bold uppercase tracking-tight">
                        Add Entry
                    </a>
                    <a @click="!importRunning ? showImportModal = true : null" class="cursor-pointer flex items-center mr-4 px-3 py-2 bg-blue-700 rounded-md text-white text-xs font-bold uppercase tracking-tight">
                        Import CSV
                    </a>
                </div>
            </div>
            <div class="my-auto text-right font-bold text-xs uppercase tracking-tight leading-7 text-gray-400">
                Total Balance
                <span :class="{ 'block': true, 'text-3xl': true, 'font-normal': true, 'text-green-500': $root.totalBalance > 0, 'text-gray-500': $root.totalBalance <= 0 }" v-if="formattedBalance">
                    ${{ formattedBalance }}.<span class="text-xl">{{ formattedBalanceDecimal | roundDecimals }}</span>
                </span>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-2" v-if="importRunning">
        <div class="mb-8">
            <div class="bg-yellow-100 rounded-lg py-5 px-6 mb-4 text-base text-yellow-700 mb-3" role="alert">
            We're importing {{ importRows }} balance entries. Sit tight.
            </div>
        </div>
    </div>
</div>
</template>
<script>
import Create from '../components/create.vue'
import Import from '../components/import.vue'
export default {
    components: {
        'create': Create,
        'import': Import
    },
    data() {
        return {
            showCreateModal: false,
            showImportModal: false,
            importRunning: false,
            importRows: 0,
        }
    },
    mounted() {
        var app = this
        this.$bus.$on('importRunning', (value, rows) => {
            app.importRunning = value
            app.importRows = rows
            app.showImportModal = false
        })
        this.watchImports()
    },
    computed: {
        formattedBalance() {
            return Math.trunc(this.$root.totalBalance).toLocaleString('en-US');
        },
        formattedBalanceDecimal() {
            return (this.$root.totalBalance + "").split(".")[1];
        }
    },
    methods: {
        transactionCreated() {
            this.showCreateModal = false;
            this.$bus.$emit('refrshTransactions')
        },
        watchImports() {
            var app = this
            socket.on("yourbalance_database_imports:App\\Events\\ImportDone", data => {
                // @TODO: Might need to filter out the socketIO events to be sent only
                // to the appropiate authenticated user.
                app.$bus.$emit('importRunning', false, 0);
                app.$bus.$emit('refrshTransactions')
            });
        }
    }
}
</script>
