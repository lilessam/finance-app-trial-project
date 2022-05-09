require('./bootstrap');
require('./plugins')

import Vue from 'vue'
import VueTailwindModal from "vue-tailwind-modal"
import * as TransactionService from './services/TransactionService'

Vue.prototype.$bus = new Vue()
Vue.prototype.$transactions = TransactionService
Vue.config.productionTip = false
Vue.component('header-nav', require('./components/header-nav.vue').default);
Vue.component('head-panel', require('./components/head-panel.vue').default);
Vue.component('entries', require('./components/entries.vue').default);
Vue.component("VueTailwindModal", VueTailwindModal)
Vue.filter("currency", require('./filters/currency').default);
Vue.filter("roundDecimals", require('./filters/roundDecimals').default);

new Vue({
  el: '#app',
  data() {
    return {
      totalBalance: null
    }
  }
})
