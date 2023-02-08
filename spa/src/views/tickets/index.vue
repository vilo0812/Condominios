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
              Anuncios
              <v-spacer />
              <template v-if="isAdmin">
              <v-btn
                color="primary"
                large
              @click="changeModalState(true, 'Crear')"
              >
                Agregar Anuncio
              </v-btn>
              </template>
            </v-card-title>
            <template v-if="isAdmin">
            <Simpletable   @seeing="seeing" @editing="editing" @deleting="deleting" @openCreatePagoTicket="openCreatePagoTicket"/>
            </template>
            <template v-else>
              <SimpletableUser   @seeing="seeing" @editing="editing" @deleting="deleting" @openCreatePagoTicket="openCreatePagoTicket"/>
            </template>
          </v-card>
        </v-col>
      </v-row>
      <!--   Modal Update Or Create User -->
      <UpdateOrCreate :action="action" :data="ticket" @close="close"/>
      <!--   Create Pago TIcket -->
      <CreatePagoTicket action="Pagar" :data="ticket" />
      <!--   Modal Delete User -->
      <DeleteModal :data="ticket" module-name="Anuncio" action-delete-name="deleteTicket"/>
      <!--   Modal Image Pago -->
      <ImageModal :data="pago" module-name="Pago"/>
    </div>
  </template>

  <script>
    import Simpletable from '@/components/tickets/Simpletable.vue'
    import SimpletableUser from '@/components/tickets/SimpletableUser.vue'
    import UpdateOrCreate from '@/components/tickets/UpdateOrCreate.vue'
    import CreatePagoTicket from '@/components/pagos/CreatePagoTicket.vue'
    import DeleteModal from '@/components/base/modals/DeleteModal.vue'
    import ImageModal from '@/components/base/modals/ImageModal.vue'
    import { mapGetters } from 'vuex'
    export default {
      name: 'Tickets',
      data () {
        return {
          action : '',
          ticket: null,
          pago: null
        }
      },
      components: {
        Simpletable,
        UpdateOrCreate,
        CreatePagoTicket,
        DeleteModal,
        ImageModal,
        SimpletableUser
      },
      computed: {
        ...mapGetters({
          isAdmin: 'isAdmin'
        }),
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
        seeing(pago){
          this.pago = pago
          console.log(pago)
          this.$store.commit('CHANGE_MODAL_IMAGE_STATE', true)
        },
        openCreatePagoTicket(ticket){
          this.ticket = ticket
          this.$store.commit('CHANGE_MODAL_CREATE_PAGO_TICKET_STATE', true)
        },
      }
    }
  </script>
  
  <style>
  
  </style>