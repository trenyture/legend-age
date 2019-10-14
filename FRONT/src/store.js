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
	},
	getters: {
		getBasket(state) {
			return state.basket;
		}
	},
	mutations: {
		addBasketLine(state, basketLine) {
			this.basket.push(basketLine);
		},
		deleteBasketLine(state, index) {
			this.basket.splice(index, 1);
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
	}
})
