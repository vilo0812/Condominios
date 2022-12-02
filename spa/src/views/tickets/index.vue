<template>
    <div>
      <v-row
      align="center"
      justify="center"
      >
        <v-col
        cols="12"
        sm="9"
        >
          <v-card 
            class="elevation-2"
            color="deep-purple accent-4"
          >
            <v-card-title>
              Tickets
              <v-spacer />
              <v-btn
                color="primary"
                large
              @click="changeModalState(true, 'Crear')"
              >
                Agregar Ticket
              </v-btn>
            </v-card-title>
            <Simpletable  @editing="editing" @deleting="deleting"/>
          </v-card>
        </v-col>
      </v-row>
      <!--   Modal Update Or Create User -->
      <UpdateOrCreate :action="action" :data="ticket" @close="close"/>
      <!--   Modal Delete User -->
      <DeleteModal :data="ticket" module-name="Ticket" action-delete-name="deleteTicket"/>
    </div>
  </template>
  
  <script>
    import Simpletable from '@/components/tickets/Simpletable.vue'
    import UpdateOrCreate from '@/components/tickets/UpdateOrCreate.vue'
    import DeleteModal from '@/components/base/modals/DeleteModal.vue'
    export default {
      name: 'Tickets',
      data () {
        return {
          action : '',
          ticket: null
        }
      },
      components: {
        Simpletable,
        UpdateOrCreate,
        DeleteModal
      },
      methods: {
        changeModalState(state, action = null) {
          this.ticket = null
          this.action = action
          this.$store.commit('CHANGE_MODAL_STATE', state)
        },
        editing(ticket){
          this.changeModalState(true, 'Editar')
          this.ticket = ticket
        },
        deleting(ticket){
          this.ticket = ticket
          this.$store.commit('CHANGE_MODAL_DELETE_STATE', true)
        },
        close(){
          this.ticket = null
          this.action = null
          this.$store.commit('CHANGE_MODAL_STATE', false)
        },
      }
    }
  </script>
  
  <style>
  
  </style>