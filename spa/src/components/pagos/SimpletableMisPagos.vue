<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <!-- <th class="text-left">
              Condominio
            </th> -->
            <th class="text-left">
              Cantidad
            </th>
            <th class="text-left">
              Estado
            </th>
            <th class="text-left">
              Tema
            </th>
            <th class="text-rigth">
              Ver pago
            </th>
            <!-- <th class="text-rigth">
              Actualizar Pago
            </th> -->
            <th class="text-rigth">
              Estado
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in misPagos"
            :key="item.id"
          >
            <!-- <td>{{ getCondominio(item.condominio_id) }}</td> -->
            <td>{{ item.amount }}</td>
            <td>{{ item.status }}</td>
            <td>{{ getIssue(item.support_id) }}</td>
            <td class="text-left">
                <v-btn
                  depressed
                  color="info" 
                  @click="seeing(item)"
                >
                  ver
                </v-btn>
            </td>
            <!-- <td class="text-left">
                <v-btn
                  depressed
                  color="warning" 
                  @click="editing(item)"
                  v-if="item.status == 'rechazado'"
                >
                  Actualizar
                </v-btn>
            </td> -->
            <td class="text-left">
              <template v-if="item.status == 'aprobado'">
                <a
                    style="text-decoration: none;color:white;background: rgb(33, 150, 210);border-radius: 5px;padding: 10px; margin: 5px;"
                    :href="getReference(item.id)"
                  >
                  <span class="v-btn content"> ver factura </span>
                </a>
              </template>
              <template v-if="item.status == 'activo'">
                <v-chip
                  class="ma-2"
                  color="warning"
                  text-color="white"
                >
                  pago en revision
                </v-chip>
              </template>
              <template v-if="item.status == 'rechazado'">
                <v-chip
                  class="ma-2"
                  color="error"
                  text-color="white"
                >
                  pago rechazado
                </v-chip>
              </template>
            </td>
          </tr>
        </tbody>
      </template>
  </v-simple-table>
</template>

<script>
  import axios from 'axios'
  import { mapGetters,mapActions } from 'vuex'
  export default {
    name: 'SimpletableMisPagos.vue',
    data: () => ({
    }),
    computed: {
      ...mapGetters({
        misPagos: 'misPagos',
        condominios: 'condominios',
        user: 'user',
        facturas: 'facturas',
        tickets: 'tickets'
      })
    },
    methods:{
      ...mapActions({
        getMisPagos: 'getMisPagos',
        getCondominios: 'getCondominios',
        setOverlay: 'setOverlay',
        getFacturas: 'getFacturas',
        getTicketsAdmin: 'getTicketsAdmin'
      }),
      getIssue(support_id){
        let IssueTake;
        this.tickets.forEach( (t) =>{
          if(t.id == support_id){
            IssueTake = t.issue
          }
        });
        return IssueTake;
      },
      getTicket(support_id){
        let ticketTake;
        this.tickets.forEach( (t) =>{
          if(t.id == support_id){
            ticketTake = t
          }
        });
        return ticketTake;
      },
      getReference(pago_id){
        let FacturaTake;
        this.facturas.forEach( (f) =>{
          if(f.pago_id == pago_id){
            FacturaTake = f.reference;
          }
        });
        return FacturaTake;
      },
      // async getHref (id){
      //   let url = ''
      //   const resp = (
      //     await axios.get(`/api/PaymentFacture/${id}`)
      //   ).data
      //   url = resp.reference
      //   console.log(url)
      //   return url
      // },
      editing: function(pago) {
        //let ticket = this.getTicket(pago.support_id)
        this.$emit("editing",pago);
      },
      deleting: function(pago) {
        this.$emit("deleting",pago);
      },
      seeing: function(pago) {
        this.$emit("seeing",pago);
      },
      openCreatePagoTicket(){
          this.$store.commit('CHANGE_MODAL_CREATE_PAGO_TICKET_STATE', true)
        },
      getCondominio(id){
        let Condominio;
        this.condominios.forEach( (c) =>{
          if(c.id == id){
            Condominio = c.name;
          }
        });
        return Condominio;
      }
    },
    async created() {
      this.setOverlay(true)
      try {
        await this.getMisPagos(this.user.id)
        await this.getTicketsAdmin()
        if(this.facturas.length <= 0){
          await this.getFacturas()
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
    }
  }
</script>

<style>

</style>