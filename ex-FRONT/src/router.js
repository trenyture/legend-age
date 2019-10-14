import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

Vue.use(Router);

let router = new Router({
	mode: 'history',
	routes: [
		{
			path: '/',
			name: 'root',
			component: resolve => require(['./views/Root/Root.vue'], resolve),
			meta: {
				pageTitle: 'Un baume mille couleurs',
			}
		},
		/**************   ENFIN ON CRÉER LA PAGE D'ERREUR   **************/
		{
			path: '/error',
			name: 'errors',
			component: resolve => require(['./views/Error/Error.vue'], resolve),
		},
		{
			path: '/*',
			name: 'others',
			redirect: { name: 'errors' },
		},
	],
});

export default router;