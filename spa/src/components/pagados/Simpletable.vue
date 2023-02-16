<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <!-- <th class="text-left">
              Condominio
            </th> -->
            <th class="text-left">
              Cliente
            </th>
            <th class="text-left">
              Cantidad
            </th>
            <th class="text-left">
              Estado
            </th>
            <th class="text-left">
              Titulo
            </th>
            <th class="text-left">
              Categoria
            </th>
            <th class="text-left">
              Fecha de pago
            </th>
            <th class="text-rigth">
              Ver pago
            </th>
            <th class="text-rigth">
              Aprobados
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in pagados"
            :key="item.id"
          >
            <td>{{ getUser(item.user_id) }}</td>
            <!-- <td>{{ getCondominio(item.condominio_id) }}</td> -->
            <td>{{ item.amount }}</td>
            <td>{{ item.status }}</td>
            <td>{{ getIssue(item.support_id) }}</td>
            <td>{{ getCategory(item.support_id) }}</td>
            <td>{{ item.fecha_pago }}</td>
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
                  <v-btn
                  depressed
                  color="info" 
                  @click="Generate(item.id)"
                >
                  aprobar
                </v-btn>
                </template>
            </td>
            <td class="text-left">
              <v-btn
                  depressed
                  color="error"
                @click="Rechazo(item.id)"
                >
                  Rechazar Pago
                </v-btn>
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
      categorias : [
        {id: 1,name:"Regular"},
        {id: 2,name:"Evento"},
        {id: 3,name:"Irregular"},
        {id: 4,name:"Anuncio"}
      ],
    }),
    computed: {
      ...mapGetters({
        pagados: 'pagados',
        condominios: 'condominios',
        users: 'users',
        tickets: 'tickets'
      })
    },
    methods:{
      ...mapActions({
        getPagados: 'getPagados',
        getTicketsAdmin : 'getTicketsAdmin',
        getCondominios: 'getCondominios',
        GenerateFacture: 'GenerateFacture',
        setOverlay: 'setOverlay',
        RechazarPago: 'RechazarPago',
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
      getCategory: function(ticket_id) {
        let TicketTake;
        this.tickets.forEach( (t) =>{
          if(t.id == ticket_id){
            TicketTake = t.categorie_id
          }
        });
        let CategorieTake;
        this.categorias.forEach( (c) =>{
          if(c.id == TicketTake){
            CategorieTake = c.name;
          }
        });
        return CategorieTake;
      },
      getFecha: function(ticket_id) {
        let TicketTake;
        this.tickets.forEach( (t) =>{
          if(t.id == ticket_id){
            TicketTake = t.created_at
          }
        });
        var date = new Date(TicketTake);
        return date.toLocaleString();
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
      getUser(id){
        let UserTake;
        this.users.forEach( (c) =>{
          if(c.id == id){
            UserTake = c.name;
          }
        });
        return UserTake;
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
        let data = {
          id : this.$route.params.id
        }
        await this.getPagados(data)
        // if(this.condominios.length <= 0){
        //   await this.getCondominios()
        // }
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