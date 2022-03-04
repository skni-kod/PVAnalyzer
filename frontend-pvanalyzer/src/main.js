import { createApp } from 'vue'

import router from './router.js'
import store from './store/index.js';

import App from './App.vue'
import BaseCard from './components/ui/BaseCard.vue';
import BaseBlueButton from './components/ui/BaseBlueButton.vue';
import BaseDialog from './components/ui/BaseDialog.vue';
import FlashMessage from './components/ui/FlashMessage.vue';
import LoginRegisterCard from './components/ui/LoginRegister.vue';

import axios from 'axios'
import VueAxios from 'vue-axios'
import '@fortawesome/fontawesome-free/js/all.js'
// import Chartkick from 'vue-chartkick';
// import Chart from 'chartkick/chart.js';


const app = createApp(App);


app.use(router);
app.use(store);
app.use(VueAxios, axios);
// app.use(Chartkick.use(Chart))


app.component('base-card', BaseCard);
app.component('base-dialog', BaseDialog);
app.component('base-blue-button', BaseBlueButton);
app.component('base-login-register', LoginRegisterCard);
app.component('flash-message', FlashMessage);

app.mount('#app')
