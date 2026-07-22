import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'bootstrap-icons/font/bootstrap-icons.css';
import i18n from '@/i18n' // Импортируем нашу настройку

const appElement = document.getElementById('app');

if (appElement) {
    createApp(App).use(router).use(i18n).mount('#app');
}
