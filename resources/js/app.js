
import { createApp } from 'vue';

import Heade from './components/Heade.vue';
import Foote from './components/Foote.vue';
import Selection from './components/Selection.vue';
import Heatmap from './components/Heatmap.vue';

import '@syncfusion/ej2-vue-dropdowns';
import * as Vue from 'vue';




const app = createApp({
    components: {
        Heade,
        Foote,
        Selection,
        Heatmap,
      

    },
});

app.mount('#app');
