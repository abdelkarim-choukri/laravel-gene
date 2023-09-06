// import './bootstrap';
// import { createApp } from 'vue/dist/vue.esm-bundler.js';
// import { defineComponent } from 'vue'; // Add this import
// import Vue from 'vue'
// // Import your components
// import Header from './components/Header.vue';
// import Footer from './components/Footer.vue';

// // const app = createApp({
// //     name: 'App',
// //     components: {
// //         Header,
// //         Footer,
// //     },
// // });

// // // // Register components globally
// // app.component('Header', Header);
// // // app.component('Footer', Footer);

// Vue.component('Header-component', require('./components/Header.vue').default);

// app.mount('#app');
import { createApp } from 'vue';
import Heade from './components/Heade.vue';
import Foote from './components/Foote.vue';
import Selection from './components/Selection.vue';
const app = createApp({
    components: {
        Heade,
        Foote,
        Selection,
    },
});


app.mount('#app');
