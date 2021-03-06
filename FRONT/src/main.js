import Vue        from 'vue'
import { Plugin } from 'vue-fragment'
import VueGtag    from "vue-gtag"
import App        from './components/App/App.vue'
import config     from './config'
import router     from './router'
import store      from './store'
import alert      from './alert'
import ajax       from './ajax'
import error      from './error'

Vue.config.productionTip = false
Vue.use(Plugin)

Vue.use(VueGtag, {
	config: { id: "UA-154673627-1" }
}, router);

Vue.prototype.$alert = alert;
Vue.prototype.$ajax  = ajax;
Vue.prototype.$error = error;

/**
 * ADD FUNCTIONS AND VARIABLES TO GLOBAL OBJECT
 */
Vue.mixin({
	data() {
		return {
			apiUrl          : config.apiUrl,
			stripePublicKey : config.stripePublicKey,
			paypalPublicKey : config.paypalPublicKey,
			isPromo         : 4.01,
			isBlackFriday   : false,
		}
	},
});

new Vue({
	router,
	store,
	render: h => h(App)
}).$mount('#app');