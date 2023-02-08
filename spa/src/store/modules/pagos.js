import axios from 'axios'
export default {
  state: {
    pagos: [],
    pagados: [],
    misPagos: [],
    facturas:[],
    pagoPagitane: []
  },
  mutations: {
    SET_PAGOS (state, data) {
        state.pagos = data.pagos
        state.pagoPagitane = data.paginate
    },
    SET_PAGADOS (state, data) {
      state.pagados = data
    },
    SET_FACTURAS(state, data){
      state.facturas = data.pagos
    },
    SET_RECHAZADO(state, data){
      let index = state.pagados.findIndex((o) => o.id === data.pago_id)
      state.pagados[index].status = "rechazado"
    },
    SET_FACTURA(state, data){
      let index = state.pagados.findIndex((o) => o.id === data.pago_id)
      state.pagados[index].status = "aprobado"
    },
    SET_MISPAGOS (state, data) {
      state.misPagos = data
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
    pagados: state => state.pagados,
    misPagos: state => state.misPagos,
    facturas: state => state.facturas,
  },
  actions: {
    async getFacturas({ commit }) {
      const resp = (
        await axios.get(`/api/facturas`)
      ).data
      commit('SET_FACTURAS', resp)
      return resp
    },
    async getFacture({ commit },id) {
      const resp = (
        await axios.get(`/api/PaymentFacture/${id}`)
      ).data
      commit('SET_FACTURE', resp)
      return resp
    },
    async getPagos({ commit }) {
      const resp = (
        await axios.get(`/api/pago?page=1&rol=2&perPage=100&order=desc`)
      ).data
      commit('SET_PAGOS', resp)
      return resp
    },
    async GenerateFacture({ commit }, { data }) {
      const resp = (await axios.post('/api/pago/status_pago/generateFacura',data)).data
      commit('SET_FACTURA', data)
      return resp.factura
    },
    async RechazarPago({ commit }, { data }) {
        const resp = (await axios.post('/api/pago/status_pago/generateFacura',data)).data
        commit('SET_RECHAZADO', data)
        return resp
    },
    async getPagados({ commit },{id}) {
      const resp = (
        await axios.get(`/api/listPayment/${id}`)
      ).data
      commit('SET_PAGADOS', resp)
      return resp
    },
    async getMisPagos({ commit },id) {
      const resp = (
        await axios.get(`/api/user/${id}/pago`)
      ).data
      commit('SET_MISPAGOS', resp.pagos)
      return resp.pagos
    },
    async updateOrCreatePagos({ commit }, {pago, id} ) {
      console.log("llegamos a pagos")
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
        pago.append("pago_id", id);
        const response = axios({
          method: 'post',
          url: `/api/update-pago`,
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