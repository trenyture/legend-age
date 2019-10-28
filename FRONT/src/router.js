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
		{
			path: '/product',
			name: 'product',
			component: resolve => require(['./views/Product/Product.vue'], resolve),
			meta: {
				pageTitle: 'Soins des lèvres',
			}
		},
		{
			path: '/basket',
			name: 'basket',
			component: resolve => require(['./views/Basket/Basket.vue'], resolve),
			meta: {
				pageTitle: 'Mon panier',
			}
		},
		{
			path: '/order/:stripeId?',
			name: 'order',
			component: resolve => require(['./views/Order/Order.vue'], resolve),
			meta: {
				pageTitle: 'Paiement',
			}
		},
		{
			path: '/account',
			name: 'account',
			component: resolve => require(['./views/Account/Account.vue'], resolve),
			meta: {
				pageTitle: 'Mon compte',
			}
		},
		{
			path: '/contact',
			name: 'contact',
			component: resolve => require(['./views/Contact/Contact.vue'], resolve),
			meta: {
				pageTitle: 'Demande de contact',
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