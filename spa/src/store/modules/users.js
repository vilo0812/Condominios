import axios from 'axios'
export default {
  state: {
    users: [],
    userPagitane: []
  },
  mutations: {
    SET_USERS (state, data) {
        state.users = data.users
        state.userPagitane = data.paginate
    },
    async SET_NEW_USER(state, user) {
      // departament.mayor_id = (await axios.get(`/api/mayors/${departament.mayor_id}`)).data
      console.log(user)
      state.users.push(user)
    },
    UPDATE_USER(state, { id, name, email, password }) {
      let index = state.users.findIndex((o) => o.id === id)
      state.users[index].name = name
      state.users[index].email = email
      state.users[index].password = password
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
      commit('SET_USERS', resp)
      return resp
    },
    async updateOrCreateUsers({ commit }, { user, id }) {
      if (!id) {
        user.rol = 2;
        const resp = (await axios.post('/api/users',user)).data
        commit('SET_NEW_USER', resp.data)
        return resp
      } else {
        //TODO debemos probar porque no se mete en el array
        const resp = (await axios.put(`/api/users/${id}`,user))
          .data
        commit('UPDATE_USER', resp.data)
        return resp
      }

    },
    async deleteUser({ commit }, id) {
      const resp = (await axios.delete(`/api/users/${id}`)).data
      commit('SPLICE_USER_DELETED', id)
      return resp
    }
  }
}