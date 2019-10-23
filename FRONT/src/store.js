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
		basket : [],
		contactFormSent: {
			value: false,
			expires: null,
		},
	},
	getters: {
		getBasket(state) {
			return state.basket;
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
		deleteBasketLine(state, index) {
			state.basket.splice(index, 1);
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
		deleteBasketLine(context, payload) {
			return new Promise((resolve, reject) => {
				context.commit('deleteBasketLine', payload);
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
