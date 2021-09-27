<template>
  <div v-if="Object.keys(locales).length > 1" class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
    >
      {{ locales[locale] }} - <img :src="`https://www.countryflags.io/${flags[locale]}/flat/32.png`" >
    </a>
    <div class="dropdown-menu">
      <a v-for="(value, key) in flags" :key="key" class="dropdown-item" href="#"
         @click.prevent="setLocale(key)"
      >
        <img :src="`https://www.countryflags.io/${value}/flat/32.png`" >
      </a>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

export default {
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales',
    flags: 'lang/flags'
  }),

  methods: {
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    }
  }
}
</script>
