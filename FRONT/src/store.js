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
		contactFormSent: false,
	},
	getters: {
		getBasket(state) {
			return state.basket;
		},
		contactFormSent(state) {
			return state.contactFormSent;
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
			state.contactFormSent = value;
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
