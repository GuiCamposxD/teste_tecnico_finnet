import './assets/main.css'
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

import { registerPlugins } from '@/plugins'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import App from './App.vue'

import { createApp } from 'vue'

const app = createApp(App)

registerPlugins(app)

app.component('VueDatePicker', VueDatePicker);
app.mount('#app')
