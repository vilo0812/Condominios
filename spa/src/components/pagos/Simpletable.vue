<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <!-- <th class="text-left">
              Condominio
            </th> -->
            <th class="text-left">
              Usuario
            </th>
            <th class="text-left">
              Tema
            </th>
            <th class="text-left">
              Cantidad
            </th>
            <th class="text-left">
              Estado
            </th>
            <th class="text-rigth">
              Ver pago
            </th>
            <th class="text-rigth">
              estatus
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in pagos"
            :key="item.id"
          >
            <!-- <td>{{ getCondominio(item.condominio_id) }}</td> -->
            <td>{{ getUser(item.user_id) }}</td>
            <td>{{ getIssue(item.support_id) }}</td>
            <td>{{ item.amount }}</td>
            <td>{{ item.status }}</td>
            <td class="text-left">
                <v-btn
                  depressed
                  color="info" 
                  @click="seeing(item)"
                >
                  ver
                </v-btn>
            </td>
            <td class="text-left">
                <template v-if="item.status == 'aprobado'">
                  <v-chip
                  class="ma-2"
                  color="green"
                  text-color="white"
                >
                  pago Aprobado
                </v-chip>
                </template>
                <template v-if="item.status == 'rechazado'">
                  <v-chip
                  class="ma-2"
                  color="error"
                  text-color="white"
                >
                  pago Rechazado
                </v-chip>
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
    name: 'Simpletable',
    data: () => ({
    }),
    computed: {
      ...mapGetters({
        pagos: 'pagos',
        condominios: 'condominios',
        users: 'users',
        tickets: 'tickets'
      })
    },
    methods:{
      ...mapActions({
        getPagos: 'getPagos',
        getCondominios: 'getCondominios',
        setOverlay: 'setOverlay',
        RechazarPago: 'RechazarPago',
        GenerateFacture: 'GenerateFacture',
        getTicketsAdmin : 'getTicketsAdmin',
        getUsers: 'getUsers'
      }),
      getIssue: function(ticket_id) {
        let TicketTake;
        this.tickets.forEach( (t) =>{
          if(t.id == ticket_id){
            TicketTake = t.issue
          }
        });
        return TicketTake;
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
      async Rechazo(pago_id){
      this.setOverlay(true)
      let data = {
        pago_id : pago_id,
        status : "rechazado"
      }
      try {
        const resp = await this.RechazarPago({ data })
        this.$swal({
            icon: 'success',
            title: '¡Exito!',
            confirmButtonColor: '#3085d6',
          })
        this.setOverlay(false)
      } catch (error) {
          console.log(error)
          this.$swal({
            icon: 'error',
            title: '¡Error con los registros!',
            confirmButtonColor: '#3085d6',
          })
          this.setOverlay(false)
      }
      },
      async Generate(pago_id){
      this.setOverlay(true)
      let data = {
        pago_id : pago_id,
        status : "aprobado"
      }
      try {
        const resp = await this.GenerateFacture({ data })
        this.$swal({
            icon: 'success',
            title: '¡Exito!',
            confirmButtonColor: '#3085d6',
          })
        this.setOverlay(false)
      } catch (error) {
          console.log(error)
          this.$swal({
            icon: 'error',
            title: '¡Error con los registros!',
            confirmButtonColor: '#3085d6',
          })
          this.setOverlay(false)
      }
      },
      editing: function(pago) {
        this.$emit("editing",pago);
      },
      deleting: function(pago) {
        this.$emit("deleting",pago);
      },
      seeing: function(pago) {
        this.$emit("seeing",pago);
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
        await this.getUsers()
        await this.getTicketsAdmin()
        await this.getPagos()
        if(this.condominios.length <= 0){
          await this.getCondominios()
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