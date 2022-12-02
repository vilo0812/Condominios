import Vue from 'vue'
import Vuex from 'vuex'
import config from './modules/config'
import auth from './modules/auth'
import users from './modules/users'
import condominios from './modules/condominios'
import pagos from './modules/pagos'
import tickets from './modules/tickets'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  	modal: false,
    modalDelete: false,
    modalImage: false
  },
  mutations: {
  	CHANGE_MODAL_STATE(state, stateModal) {
      state.modal = stateModal
    },
    CHANGE_MODAL_DELETE_STATE(state, stateModal) {
      state.modalDelete = stateModal
    },
    CHANGE_MODAL_IMAGE_STATE(state, stateModal) {
      state.modalImage = stateModal
    }
  },
  actions: {},
  getters: {
  	modalState: (state) => state.modal,
  	modalImageState: (state) => state.modalImage,
    modalDeleteState: (state) => state.modalDelete
  },
  modules: {
  	config,
    auth,
    users,
    condominios,
    pagos,
    tickets
  }
})