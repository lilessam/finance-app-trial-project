import Vue from 'vue'
import VeeValidate from 'vee-validate'

const dictionary = {
    custom: {
        amount_date: {
          required: 'The date field is required'
        },
      }
};

Vue.use(VeeValidate, { delay: 250, useConstraintAttrs: false })

VeeValidate.use(({ Validator }) => {
    Validator.localize('en', dictionary);
});

Vue.mixin({
    $_veeValidate: {
        validator: 'new'
    },
    methods: {
        async formHasErrors () {
            const valid = await this.$validator.validateAll()
            if (valid) {
                this.$validator.pause()
            }
            return !valid
        }
    }
})


