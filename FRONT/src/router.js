import Vue    from 'vue'
import Router from 'vue-router'
import store  from './store'

Vue.use(Router)

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
			path: '/order/',
			name: 'order',
			component: resolve => require(['./views/Order/Order.vue'], resolve),
			meta: {
				pageTitle: 'Paiement',
			}
		},
		{
			path: '/order/confirmed/:type(\\paypal|stripe)/:orderId',
			name: 'confirmed',
			component: resolve => require(['./views/Order/Confirmed.vue'], resolve),
			meta: {
				pageTitle: 'Achat confirmé',
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
		{
			path: '/conditions',
			name: 'cgv',
			component: resolve => require(['./views/CGV/CGV.vue'], resolve),
			meta: {
				pageTitle: 'Conditions générales de vente',
			}
		},
		{
			path: '/avis',
			name: 'notation',
			component: resolve => require(['./views/Avis/Avis.vue'], resolve),
			meta: {
				pageTitle: 'Laissez-nous un avis',
			}
		},
		{
			path: '/admin',
			name: 'admin',
			component: resolve => require(['./views/Admin/Admin.vue'], resolve),
			meta: {
				pageTitle: 'Administration',
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