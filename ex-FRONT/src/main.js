import Vue from 'vue';
import App from '@/components/App/App.vue';
import Fragment from 'vue-fragment'

import store from './store';
import router from './router';

Vue.use(Fragment.Plugin)

new Vue({
	store,
	router,
	render: h => h(App),
}).$mount('#app')