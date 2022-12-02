import axios from 'axios'
export default {
  state: {
    pagos: [],
    pagoPagitane: []
  },
  mutations: {
    SET_PAGOS (state, data) {
        state.pagos = data.pagos
        state.pagoPagitane = data.paginate
    },
    async SET_NEW_PAGO(state, pago) {
      state.pagos.push(pago)
    },
    UPDATE_PAGO(state, { id, name, email, password }) {
      let index = state.users.findIndex((o) => o.id === id)
      state.pagos[index].name = name
      state.pagos[index].email = email
      state.pagos[index].password = password
    },
    SPLICE_PAGO_DELETED(state, id) {
      let index = state.pagos.findIndex((o) => o.id === id)
      state.pagos.splice(index, 1)
    }
  },
  getters: {
    pagos: state => state.pagos,
  },
  actions: {
    async getPagos({ commit }) {
      const resp = (
        await axios.get(`/api/pago?page=1&rol=2&perPage=100&order=desc`)
      ).data
      commit('SET_PAGOS', resp)
      return resp
    },
    async updateOrCreatePagos({ commit }, { pago, id }) {
      if (!id) {
        const response = axios({
          method: 'post',
          url: '/api/pago',
          data: pago,
          headers: {'Content-Type': 'multipart/form-data' }
          });
          response.then(resp => {
            commit('SET_NEW_PAGO', resp.data.data)
            return resp
          });
      } else {
        const response = axios({
          method: 'put',
          url: `/api/pago/${id}`,
          data: pago,
          headers: {'Content-Type': 'multipart/form-data' }
          });
          response.then(resp => {
            commit('UPDATE_PAGO', resp.data.data)
            return resp
          });
      }

    },
    async deletePago({ commit }, id) {
      const resp = (await axios.delete(`/api/pago/${id}`)).data
      commit('SPLICE_PAGO_DELETED', id)
      return resp
    }
  }
}