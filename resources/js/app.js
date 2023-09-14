/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import router from "./routes";
import store from './store';






const app = createApp({});

app.use(router);

app.use(store);

import AppComponent from './components/AppComponent.vue';
import WelcomeComponent from './Components/WelcomeComponent.vue';
app.component('app-component', AppComponent);
app.component('welcome-component', WelcomeComponent)




app.mount('#app');
