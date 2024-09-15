import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import StatementComponent from './components/StatementComponent.vue';
app.component('statement-component', StatementComponent);

app.mount('#app');
