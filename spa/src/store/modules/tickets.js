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
      state.tickets.push(ticket.data)
    },
    UPDATE_TICKET(state, { id, user_id, email, categorie_id,priority,status,issue,expiration,file,amount }) {
      let index = state.tickets.findIndex((o) => o.id === id)
      state.tickets[index].amount = amount
      state.tickets[index].user_id = user_id
      state.tickets[index].email = email
      state.tickets[index].categorie_id = categorie_id
      state.tickets[index].priority = priority
      state.tickets[index].issue = issue
      state.tickets[index].status = status
      state.tickets[index].file = file
      state.tickets[index].expiration = expiration
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
    async getTicketsByIdAdmin(id) {
      const resp = (
        await axios.get(`/api/ticket-show-admin/${id}`)
        ).data
        return resp.data
    },
    async getTicketsAdmin({ commit }) {
      const resp = (
        await axios.get(`/api/ticket-list-admin`)
        ).data
        commit('SET_TICKETS', resp)
        return resp
    },
    async getTicketsUser({ commit },id) {
      const resp = (
        await axios.get(`/api/ticket-list-user/${id}`)
        ).data
        commit('SET_TICKETS', resp)
        return resp
    },
    async updateOrCreateTicketsAdmin({ commit }, { ticket, id }) {
      if (!id) {
        // const resp = (await axios.post('api/ticket-store',ticket)).data
        // commit('SET_NEW_TICKET', resp.data)
        // return resp
        const response = axios({
          method: 'post',
          url: 'api/ticket-store',
          data: ticket,
          headers: {'Content-Type': 'multipart/form-data' }
          });
          response.then(resp => {
            commit('SET_NEW_TICKET', resp.data)
            return resp.data
          });
      } else {
        const response = axios({
          method: 'post',
          url: 'api/ticket-update-admin',
          data: ticket,
          headers: {'Content-Type': 'multipart/form-data' }
          });
          response.then(resp => {
            commit('UPDATE_TICKET', resp.data.data)
            return resp.data
          });
      }
    },
    async updateOrCreateTicketsUser({ commit }, { ticket, id }) {
      if (!id) {
        const response = axios({
          method: 'post',
          url: 'api/ticket-store',
          data: ticket,
          headers: {'Content-Type': 'multipart/form-data' }
          });
          response.then(resp => {
            commit('SET_NEW_TICKET', resp.data)
            return resp.data
          });
      } else {
        const response = axios({
          method: 'post',
          url: 'api/ticket-update-admin',
          data: ticket,
          headers: {'Content-Type': 'multipart/form-data' }
          });
          response.then(resp => {
            commit('UPDATE_TICKET', resp.data)
            return resp.data
          });
      }

    },
    async deleteTicket({ commit }, id) {
      //TODO debemos agregar
      const resp = (await axios.delete(`/api/ticket-delete/${id}`)).data
      commit('SPLICE_TICKET_DELETED', id)
      return resp
    }
  }
}