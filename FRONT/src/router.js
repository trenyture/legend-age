import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
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
			path: '/product',
			name: 'product',
			component: resolve => require(['./views/Product/Product.vue'], resolve),
			meta: {
				pageTitle: 'Soins des lèvres',
			}
		},
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