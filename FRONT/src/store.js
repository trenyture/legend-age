import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'

const vuexLocalStorage = new VuexPersist({
	key: 'legend.age.local.storage',
	storage: window.localStorage,
})

Vue.use(Vuex)

export default new Vuex.Store({
	plugins: [vuexLocalStorage.plugin],
	state: {
		isLoggedIn: {
			value: false,
			expires: null,
		},
		basket : [],
		contactFormSent: {
			value: false,
			expires: null,
		},
		superAdmin: false,
	},
	getters: {
		isSuperAdmin(state) {
			return state.superAdmin;
		},
		getBasket(state) {
			return state.basket;
		},
		isLoggedIn(state) {
			let d = new Date();
			return (state.isLoggedIn.expires && d.getTime() < state.isLoggedIn.expires) ? state.isLoggedIn.value : false;
		},
		contactFormSent(state) {
			let d = new Date();
			return (state.contactFormSent.expires && d.getTime() < state.contactFormSent.expires) ? state.contactFormSent.value : false;
		}
	},
	mutations: {
		addBasketLine(state, basketLine) {
			state.basket.push(basketLine);
		},
		setSuperAdmin(state, user) {
			state.superAdmin = user && user.is_admin ? true : false;
		},
		deleteBasketLine(state, index) {
			state.basket.splice(index, 1);
		},
		deleteAllBasketLine(state) {
			state.basket = [];
		},
		isLoggedIn(state, value) {
			console.log(value);
			let d = new Date();
			d.setHours(d.getHours() + 3);
			state.isLoggedIn = {
				value: value,
				expires: d.getTime(),
			};
		},
		contactFormSent(state, value) {
			let d = new Date();
			d.setHours(d.getHours() + 2);
			state.contactFormSent = {
				value: value,
				expires: d.getTime(),
			};
		},
	},
	actions: {
		addBasketLine(context, payload) {
			return new Promise((resolve, reject) => {
				context.commit('addBasketLine', payload);
				resolve();
			});
		},
		setSuperAdmin(context, payload) {
			return new Promise((resolve, reject) => {
				context.commit('setSuperAdmin', payload);
				resolve();
			});
		},
		deleteBasketLine(context, payload) {
			return new Promise((resolve, reject) => {
				context.commit('deleteBasketLine', payload);
				resolve();
			});
		},
		deleteAllBasketLine(context) {
			return new Promise((resolve, reject) => {
				context.commit('deleteAllBasketLine');
				resolve();
			});
		},
		isLoggedIn(context, payload) {
			return new Promise((resolve, reject) => {
				context.commit('isLoggedIn', payload);
				resolve();
			});
		},
		contactFormSent(context, payload) {
			return new Promise((resolve, reject) => {
				context.commit('contactFormSent', payload);
				resolve();
			});	
		},
	}
})
