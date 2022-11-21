import axios from 'axios'
export default {
  state: {
    tickets: [],
    ticketsPagitane: []
  },
  mutations: {
    SET_TICKETS (state, data) {
        state.tickets = data.users
        state.ticketsPagitane = data.paginate
    },
    async SET_NEW_TICKET(state, ticket) {
      state.users.push(ticket)
    },
    UPDATE_TICKET(state, { id, user_id,name, email, categories,priority,status }) {
      let index = state.users.findIndex((o) => o.id === id)
      state.tickets[index].name = name
      state.tickets[index].user_id = user_id
      state.tickets[index].email = email
      state.tickets[index].password = password
      state.tickets[index].categories = categories
      state.tickets[index].priority = priority
      state.tickets[index].status = status
    },
    SPLICE_TICKET_DELETED(state, id) {
      let index = state.tickets.findIndex((o) => o.id === id)
      state.tickets.splice(index, 1)
    }
  },
  getters: {
    tickets: state => state.tickets,
  },
  actions: {
    async getTickets({ commit }) {
      const resp = (
        //TODO agregar
        await axios.get(`/api/users?page=1&rol=2&perPage=100&order=desc`)
        ).data
        commit('SET_TICKETS', resp)
        return resp
    },
    async updateOrCreateTickets({ commit }, { ticket, id }) {
      if (!id) {
        user.rol = 2;
        //TODO agregar
        const resp = (await axios.post('/api/users',ticket)).data
        commit('SET_NEW_TICKET', resp.data)
        return resp
      } else {
        //TODO debemos agregar
        const resp = (await axios.put(`/api/users/${id}`,ticket))
          .data
        commit('UPDATE_TICKET', resp.data)
        return resp
      }

    },
    async deleteTicket({ commit }, id) {
      //TODO debemos agregar
      const resp = (await axios.delete(`/api/users/${id}`)).data
      commit('SPLICE_TICKET_DELETED', id)
      return resp
    }
  }
}