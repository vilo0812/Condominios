import axios from 'axios'
export default {
  state: {
    condominios: [],
    condominioPagitane: []
  },
  mutations: {
    SET_CONDOMINIOS (state, data) {
        state.condominios = data.condominios
        state.condominioPagitane = data.paginate
    },
    async SET_NEW_CONDOMINIO(state, condominio) {
      state.condominios.push(condominio)
    },
    UPDATE_CONDOMINIO(state, { id, user_id, name, description, amount,status,location }) {
      let index = state.condominios.findIndex((o) => o.id === id)
      state.condominios[index].name = name
      state.condominios[index].user_id = user_id
      state.condominios[index].description = description
      state.condominios[index].location = location
      state.condominios[index].amount = amount
      state.condominios[index].status = status
    },
    SPLICE_CONDOMINIO_DELETED(state, id) {
      let index = state.condominios.findIndex((o) => o.id === id)
      state.condominios.splice(index, 1)
    }
  },
  getters: {
    condominios: state => state.condominios,
  },
  actions: {
    async getCondominios({ commit }) {
      const resp = (
        await axios.get(`api/condominio?page=1&rol=2&perPage=100&order=desc`)
      ).data
      commit('SET_CONDOMINIOS', resp)
      return resp
    },
    async updateOrCreateCondominios({ commit }, { condominio, id }) {
      if (!id) {
        const resp = (await axios.post('/api/condominio',condominio)).data
        commit('SET_NEW_CONDOMINIO', resp.data)
        return resp
      } else {
        const resp = (await axios.put(`/api/condominio/${id}`,condominio))
          .data
        commit('UPDATE_CONDOMINIO', resp.data)
        return resp
      }

    },
    async deleteCondominio({ commit }, id) {
      console.log("estas en deletecondominio")
      console.log(id)
      const resp = (await axios.delete(`/api/condominio/${id}`)).data
      commit('SPLICE_CONDOMINIO_DELETED', id)
      return resp
    }
  }
}