import './bootstrap';
import 'mdb-vue-ui-kit';
import { createApp } from 'vue';
import Navigation from './components/Navigation.vue';
import store from './store';
import { router } from './routes.js'; 

const app = createApp(Navigation) 
    .use(store) 
    .use(router) 
    .component('navigation', Navigation)
    .mount('#app');