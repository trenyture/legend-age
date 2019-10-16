import Vue    from 'vue'
import App    from './components/App/App.vue'
import config from './config'
import router from './router'
import store  from './store'
import alert  from './alert';
import ajax  from './ajax';
import error  from './error';

Vue.config.productionTip = false

Vue.prototype.$alert = alert;
Vue.prototype.$ajax  = ajax;
Vue.prototype.$error = error;

/**
 * ADD FUNCTIONS AND VARIABLES TO GLOBAL OBJECT
 */
Vue.mixin({
	data() {
		return {
			apiUrl : config.apiUrl,
		}
	},
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');