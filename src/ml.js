import Vue from 'vue'
import { MLInstaller, MLCreate, MLanguage } from 'vue-multilanguage'

Vue.use(MLInstaller)

export default new MLCreate({
  initial: 'english',
  save: process.env.NODE_ENV === 'production',
  languages: [
    new MLanguage('english').create({
      title: 'Hello {0}!',
      menu_unread: 'Unread messages'
    }),

    new MLanguage('polski').create({
      title: 'Witaj {0}!',
      menu_unread: 'Wiadomości nieprzeczytane'
    })
  ]
})