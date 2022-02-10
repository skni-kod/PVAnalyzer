import { createApp } from 'vue'

import router from './router.js'

import App from './App.vue'
import BaseCard from './components/ui/BaseCard.vue';
import LoginRegisterCard from './components/ui/LoginRegister.vue';

import '@fortawesome/fontawesome-free/js/all.js'

const app = createApp(App);


app.use(router);

app.component('base-card', BaseCard);
app.component('base-login-register', LoginRegisterCard);

app.mount('#app')
