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
      menu_create: 'New message',
      api_failed_alert_title: ':( Server connection error',
      api_failed_alert_subtitle: 'What to do?',
      api_failed_alert_button: 'Retry',
      api_failed_alert_description1: 'retry',
      api_failed_alert_description2: 'relaunch the application / make sure your access has not expired',
      api_failed_alert_description3: 'ask IT for help',
      message_created: 'sent',
      message_expires: 'expires',
      no_title: 'no title',
      reply: 'reply',
      reply_all: 'reply to all',
      zoom_in: 'zoom in',
      zoom_out: 'zoom out',
      next_message: 'next message',
      del_message: 'delete',
      from: 'from',
      to: 'to'
    }),

    new MLanguage('polski').create({
      title: 'Witaj {0}!',
      menu_unread: 'Wiadomości nieprzeczytane',
      menu_read: 'Wiadomości przeczytane',
      menu_sent: 'Wiadomości wysłane',
      menu_create: 'Nowa wiadomość',
      api_failed_alert_title: ':( Nie mogę pobrać danych z serwera',
      api_failed_alert_subtitle: 'Co zrobić? Jak żyć?',
      api_failed_alert_button: 'Ponów próbę',
      api_failed_alert_description1: 'ponów próbę',
      api_failed_alert_description2: 'zaloguj się ponownie do aplikacji / upewnij się, że twoje loginy nie wygasły',
      api_failed_alert_description3: 'skontaktuj się z IT',
      message_created: 'wysłana',
      message_expires: 'ważna do',
      no_title: 'wiadomość bez tytułu',
      reply: 'odpowiedz',
      reply_all: 'odp. wszystkim',
      zoom_in: 'powiększ',
      zoom_out: 'pomniejsz',
      next_message: 'nast. wiadomość',
      del_message: 'skasuj',
      from: 'od',
      to: 'do'
    })
  ]
})