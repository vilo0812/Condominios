import axios from 'axios'
export default {
  state: {
    tickets: [],
    ticketsPagitane: []
  },
  mutations: {
    SET_TICKETS (state, data) {
        state.tickets = data
        // state.ticketsPagitane = data.paginate
    },
    async SET_NEW_TICKET(state, ticket) {
      state.users.push(ticket)
    },
    UPDATE_TICKET(state, { id, user_id,name, email, categories,priority,status }) {
      let index = state.users.findIndex((o) => o.id === id)
      state.tickets[index].name = name
      state.tickets[index].user_id = user_id
      state.tickets[index].email = email
      state.tickets[index].categories = categories
      state.tickets[index].priority = priority
      state.tickets[index].issue = issue
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
    async getTicketsAdmin({ commit }) {
      const resp = (
        await axios.get(`/api/ticket-list-admin`)
        ).data
        commit('SET_TICKETS', resp)
        return resp
    },
    async getTicketsUser({ commit }) {
      const resp = (
        await axios.get(`/api/ticket-list-user`)
        ).data
        commit('SET_TICKETS', resp)
        return resp
    },
    async updateOrCreateTicketsAdmin({ commit }, { ticket, id }) {
      if (!id) {
        const resp = (await axios.post('ticket-store',ticket)).data
        commit('SET_NEW_TICKET', resp.data)
        return resp
      } else {
        console.log(ticket)
        const resp = (await axios.post(`ticket-update-admin`,ticket))
          .data
        commit('UPDATE_TICKET', resp.data)
        return resp
      }

    },
    async updateOrCreateTicketsUser({ commit }, { ticket, id }) {
      if (!id) {
        const resp = (await axios.post('ticket-store',ticket)).data
        commit('SET_NEW_TICKET', resp.data)
        return resp
      } else {
        const resp = (await axios.post(`ticket-update-user`,ticket))
          .data
        commit('UPDATE_TICKET', resp.data)
        return resp
      }

    },
    async deleteTicket({ commit }, id) {
      //TODO debemos agregar
      const resp = (await axios.delete(`/api/tickets/${id}`)).data
      commit('SPLICE_TICKET_DELETED', id)
      return resp
    }
  }
}