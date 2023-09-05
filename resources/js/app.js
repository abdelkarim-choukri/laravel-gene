import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { defineComponent } from 'vue'; // Add this import

// Import your components
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

const app = createApp({
    name: 'App',
    components: {
        Header,
        Footer,
    },
});

// // Register components globally
app.component('Header', Header);
// app.component('Footer', Footer);

app.mount('#app');
