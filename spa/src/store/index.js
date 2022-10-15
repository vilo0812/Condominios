import Vue from 'vue'
import Vuex from 'vuex'
import config from './modules/config'
import auth from './modules/auth'
import users from './modules/users'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  	modal: true,
    modalDelete: false
  },
  mutations: {
  	CHANGE_MODAL_STATE(state, stateModal) {
      state.modal = stateModal
    },
    CHANGE_MODAL_DELETE_STATE(state, stateModal) {
      state.modalDelete = stateModal
    }
  },
  actions: {},
  getters: {
  	modalState: (state) => state.modal,
    modalDeleteState: (state) => state.modalDelete
  },
  modules: {
  	config,
    auth,
    users
  }
})