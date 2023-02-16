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
          <template v-if="rechazado(ticket.id)">
                  <v-chip
                  class="ma-2"
                  color="red"
                  text-color="white"
                >
                El pago fue Anterior fue rechazado, por favor volver a intentar
                </v-chip>
              </template>
            <v-card-title>
              Cartelera Informativa
              <v-spacer />
              
              <template v-if="pagado(ticket.id)">
                <v-btn
                    color="primary"
                    large
                @click="openCreatePagoTicket(ticket)"
                >
                    Reportar
                </v-btn>
                
              </template>
            </v-card-title>
          </v-card>
          <template>
        <v-card
          class="mx-auto"
        >
          <v-img
            class="white--text align-end"
            height="300px"
            :src="getUrl"
          >
            <v-card-title style="background: rgb(00,000,00,0.5);">Categoria: {{ getCategoria(ticket.categorie_id) }}</v-card-title>
          </v-img>
          
          <v-card-subtitle class="pb-0">
            Descripcion
          </v-card-subtitle>

          <v-card-text class="text--primary">
            <div>{{ ticket.issue }}</div>
          </v-card-text>

          <v-card-subtitle class="pb-0">
            Monto
          </v-card-subtitle>

          <v-card-text class="text--primary">
            <div>{{ ticket.amount }}</div>
          </v-card-text>

          <v-card-subtitle class="pb-0">
            Prioridad
          </v-card-subtitle>

          <v-card-text class="text--primary">
            <div>{{ getPriority(ticket.priority) }}</div>
          </v-card-text>

          <v-card-subtitle class="pb-0">
            Fecha de expiracion
          </v-card-subtitle>

          <v-card-text class="text--primary">
            <div>{{ ticket.expiration }}</div>
          </v-card-text>

          

          <v-card-actions>
      <v-list-item class="grow">
        <v-list-item-avatar color="grey darken-3">
          <v-img
            class="elevation-6"
            alt=""
            src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
          ></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title> <b>By:    </b>{{ getUser(ticket.user_id) }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
          </v-card-actions>
        </v-card>
      </template>
        </v-col>
      </v-row>
      
      <!--   Create Pago TIcket -->
      <CreatePagoTicket action="Pagar" :data="ticket" @close="closeCreatePagoTicket"/>
    </div>
  </template>

  <script>
    import CreatePagoTicket from '@/components/pagos/CreatePagoTicket.vue'
    import { mapGetters,mapActions } from 'vuex'
    export default {
      name: 'Details',
      data () {
        return {
          action : '',
          ticket: null,
          categorias : [
            {id: 1,name:"Servicio"},
            {id: 2,name:"Evento"},
            {id: 3,name:"Donacion"},
            {id: 4,name:"Anuncio"}
          ],
          priorities : [
          {id: 0,name:"Alta"},
          {id: 1,name:"Baja"}
        ]
        }
      },
      components: {
        CreatePagoTicket
      },
      computed: {
        ...mapGetters({
          isAdmin: 'isAdmin',
          tickets: 'tickets',
          pagos: 'pagos',
          users: 'users',
          user: 'user'
        }),
        getUrl() {
          console.log(this.ticket.file)
        return this.ticket.file != "" ? this.ticket.file : 'https://cdn.vuetifyjs.com/images/cards/docks.jpg'
      }
      },
      async created() {
      this.setOverlay(true)
      try {
        let id = this.$route.params.id;
        this.tickets.forEach(t => {
            if(t.id == id){
                this.ticket = t
            }
        });
        await this.getPagos()
        if(this.users.length <= 0){
          await this.getUsers()
        }
      this.setOverlay(false)
      } catch (error) {
        console.log(error)
        this.$swal({
          icon: 'error',
          title: '¡Error al buscar registros!',
          confirmButtonColor: '#3085d6',
        })
        this.setOverlay(false)
      }
      },
      methods: {
        ...mapActions({
        getTicketsAdmin: 'getTicketsAdmin',
        setOverlay: 'setOverlay',
        getPagos: 'getPagos',
        getUsers: 'getUsers',
        }),
        getCategoria: function(categorie_id) {
          let response = "Categoria";
        this.categorias.forEach( (c) =>{
          if(c.id == categorie_id){
            response = c.name;
          }
        });
        return response;
      },
      getUser(id){
        let UserTake;
        this.users.forEach( (c) =>{
          if(c.id == id){
            UserTake = c.name;
          }
        });
        return UserTake;
      },
      getPriority(id){
        let PrioriyTake;
        this.priorities.forEach( (c) =>{
          if(c.id == id){
            PrioriyTake = c.name;
          }
        });
        return PrioriyTake;
      },
      rechazado: function(ticket_id) {
        let response = false;
        let pago = null;
        this.pagos.forEach( (p) =>{
          if(p.user_id ==  this.user.id
          && p.support_id == ticket_id
          ){
            pago = p;
          }
        });
        if(pago != null){
          if(pago.status == 'rechazado'){
            response = true
          }
        }
        return response;
      },
        pagado: function(ticket_id) {
        let response = false;
        let pago = null;
        this.pagos.forEach( (p) =>{
          if(p.user_id ==  this.user.id
          && p.support_id == ticket_id
          ){
            pago = p;
          }
        });
        if(pago != null){
          if(pago.status == 'rechazado'){
            response = true
          }
        }else{
          response = true
        }
        return response;
      },
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
        openCreatePagoTicket(){
          this.$store.commit('CHANGE_MODAL_CREATE_PAGO_TICKET_STATE', true)
        },
        closeCreatePagoTicket(){
          this.$store.commit('CHANGE_MODAL_CREATE_PAGO_TICKET_STATE', false)
        },
      }
    }
  </script>
  
  <style>
  
  </style>