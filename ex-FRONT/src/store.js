import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'

Vue.use(Vuex);

const vuexLocalStorage = new VuexPersist({
	key: 'erp.local.storage',
	storage: window.localStorage,
});

export default new Vuex.Store({
	plugins: [vuexLocalStorage.plugin],
	state: {

	},
	getters: {

	},
	mutations: {

	},
	actions: {

	},
	strict: true,
});