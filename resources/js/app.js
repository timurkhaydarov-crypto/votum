import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap-icons/font/bootstrap-icons.css';

const appElement = document.getElementById('app');

if (appElement) {
    createApp(App).use(router).mount('#app');
}
