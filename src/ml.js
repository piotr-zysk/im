import Vue from 'vue'
import { MLInstaller, MLCreate, MLanguage } from 'vue-multilanguage'

Vue.use(MLInstaller)

export default new MLCreate({
  initial: 'english',
  save: process.env.NODE_ENV === 'production',
  languages: [
    new MLanguage('english').create({
      title: 'Hello {0}!',
      menu_unread: 'Unread messages',
      menu_read: 'Read messages',
      menu_sent: 'Sent mesages',
      menu_create: 'New message'
    }),

    new MLanguage('polski').create({
      title: 'Witaj {0}!',
      menu_unread: 'Wiadomości nieprzeczytane',
      menu_read: 'Wiadomości przeczytane',
      menu_sent: 'Wiadomości wysłane',
      menu_create: 'Nowa wiadomość'
    })
  ]
})