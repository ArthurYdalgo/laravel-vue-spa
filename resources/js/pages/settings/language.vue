<template>
  <card :title="$t('language')">
    <locale-dropdown />
  </card>
</template>

<script>
import Form from 'vform'
import LocaleDropdown from './../../components/LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>
