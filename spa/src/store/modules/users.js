import axios from 'axios'
export default {
  state: {
    users: [],
  },
  mutations: {
    SET_USERS (state, users) {
        state.users = users
    },
    async SET_NEW_USER(state, departament) {
      // departament.mayor_id = (await axios.get(`/api/mayors/${departament.mayor_id}`)).data
      state.users.push(departament)
    },
    UPDATE_USER(state, { id, name }) {
      let index = state.users.findIndex((o) => o.id === id)
      state.users[index].name = name
    },
    SPLICE_USER_DELETED(state, id) {
      let index = state.users.findIndex((o) => o.id === id)
      state.users.splice(index, 1)
    }
  },
  getters: {
    users: state => state.users,
  },
  actions: {
    async getUsers({ commit }) {
      const resp = (
        await axios.get(`/api/users?page=1&rol=2&perPage=100&order=desc`)
      ).data
      console.log(resp);
      commit('SET_USERS', resp)
      return resp
    },
    async updateOrCreateUsers({ commit }, { departament, mayor_id = 1, id }) {
      if (!id) {
        const resp = (await axios.post('/api/users',{ name : departament, mayor_id : mayor_id})).data
        commit('SET_NEW_DEPARTAMENT', resp.data)
        return resp
        return
      } else {
        const resp = (await axios.put(`/api/users/${id}`, { name : departament, mayor_id}))
          .data
        commit('UPDATE_DEPARTAMENT', resp.data)
        return resp
      }

    },
    async deleteUser({ commit }, id) {
      const resp = (await axios.delete(`/api/users/${id}`)).data
      commit('SPLICE_DEPARTAMENT_DELETED', id)
      return resp
    }
  }
}