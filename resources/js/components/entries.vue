<template>
    <div class="container mx-auto px-8">
        <div class="mb-8" v-for="(transactionGroup, transactionDate) in transactions" :key="transactionDate">
            <div class="flex items-center mb-4">
                <span class="flex-grow text-gray-500 font-bold text-sm uppercase tracking-tight">{{ transactionDate }}</span>
                <span :class="{ 'text-lg': true, 'font-bold': true, 'text-gray-500': transactionGroup.total <= 0, 'text-green-500': transactionGroup.total > 0 }">{{ transactionGroup.total | currency }}</span>
            </div>
            <!-- Transaction entries list -->
            <div v-for="transaction in transactionGroup.items" :key="transaction.id">
                <entry :transaction="transaction"></entry>
            </div>
        </div>
    </div>
</template>

<script>
import create from './create.vue'
import entry from './entry.vue'

export default {
    components: { create, entry },
    data() {
        return {
            transactions: [],
        }
    },
    async mounted() {
        this.getTransactions()
        var app = this
        this.$bus.$on('refrshTransactions', () => {
            app.getTransactions()
        })
    },
    methods: {
        async getTransactions() {
            var response = await this.$transactions.all()
            this.transactions = response.data.data
            this.$nextTick(() => {
                this.calculateTotalBalance()
            })
        },
        calculateTotalBalance() {
            this.$root.totalBalance = 0;
            for (var date in this.transactions) {
                this.$root.totalBalance += this.transactions[date].items.map(item => item.amount).reduce((prev, next) => prev + next)
            }
        }
    }
}
</script>
