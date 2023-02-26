<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              Usuario
            </th>
            <th class="text-left">
              Tema
            </th>
            <th class="text-left">
              Categoria
            </th>
            <th class="text-left">
              Monto
            </th>
            <template v-if="isAdmin">
              <th class="text-rigth">
              Pagados
              </th>
              <th class="text-rigth">
                Editar
              </th>
            </template>
            <template v-else>
              <th class="text-rigth">
              Pagados
              </th>
              <th class="text-rigth">
              Ver
              </th>
            </template>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in tickets"
            :key="item.id"
          >
            <td>{{ getUser(item.user_id) }}</td>
            <td>{{ item.issue }}</td>
            <td>{{ getCategories(item.categorie_id) }}</td>
            <!-- <td>{{ item.priority }}</td> -->
            <td>{{ item.amount }}</td> 
            <!-- <td>{{ item.issue }}</td> -->
            <template v-if="isAdmin">
            <td class="text-left" >
              <v-btn
                  depressed
                  color="info"
                  :to="`Pagados/${item.id}`"
                >
                  Pagados
                </v-btn>
            </td>
            <td class="text-left">
                <v-btn
                  depressed
                  color="warning"
                  @click="editing(item)"
                >
                  Editar
                </v-btn>
            </td>
            <!-- <td class="text-left">
                <v-btn
                  depressed
                  color="error"
                  @click="deleting(item)"
                >
                  Eliminar
                </v-btn>
            </td> -->
          </template>
        <template v-else>
          <td class="text-left" >
            <template v-if="pagado(item.id)">
                  <!-- <v-btn
                  depressed
                  color="success"
                >
                  Generar Factura
                </v-btn> -->
                <v-btn
                  depressed
                  color="info"
                  @click="seeing(item.id)"
                >
                  ver pago
                </v-btn>
              </template>
            </td>
            <td class="text-left" >
                <v-btn
                  depressed
                  color="info"
                  :to="`TicketDetails/${item.id}`"
                >
                  detalles
                </v-btn>
            </td>
        </template>
          </tr>
        </tbody>
      </template>
  </v-simple-table>
</template>

<script>
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
      priorities : [
        {id: 0,name:"Alta"},
        {id: 1,name:"Baja"}
      ],
    }),
    computed: {
      ...mapGetters({
        tickets: 'tickets',
        isAdmin: 'isAdmin',
        users: 'users',
        user: 'user',
        pagos: 'pagos',
        })
    },
    methods:{
      ...mapActions({
        getUsers: 'getUsers',
        getPagos: 'getPagos',
        getTicketsAdmin: 'getTicketsAdmin',
        getTicketsUser: 'getTicketsUser',
        setOverlay: 'setOverlay'
      }),
      rechazado: function(ticket_id) {
        let response = false;
        this.pagos.forEach( (p) =>{
          if(p.user_id ==  this.user.id &&
          p.support_id == ticket_id &&
          p.status == 'rechazado' ){
            response = true;
          }
        });
        return response;
      },
      pagado: function(ticket_id) {
        let response = false;
        this.pagos.forEach( (p) =>{
          if(p.user_id ==  this.user.id &&
          p.support_id == ticket_id){
            response = true;
          }
          else{
            response = false;
          }
        });
        return response;
      },
      editing: function(user) {
        this.$emit("editing",user);
      },
      deleting: function(user) {
        this.$emit("deleting",user);
      },
      openCreatePagoTicket: function(ticket) {
        this.$emit("openCreatePagoTicket",ticket);
      },
      seeing: function(idTicket) {
        let response = null;
        this.pagos.forEach( (c) =>{
          if(c.support_id == idTicket){
            response = c;
          }
        });
        this.$emit("seeing",response);
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
      
      getCategories(id){
        let CategorieTake;
        this.categorias.forEach( (c) =>{
          if(c.id == id){
            CategorieTake = c.name;
          }
        });
        return CategorieTake;
      },
    },
    async created() {
      this.setOverlay(true)
      try {
        if(this.users.length <= 0){
          await this.getUsers()
        }
        await this.getPagos()
        if(this.isAdmin){
          await this.getTicketsAdmin()
        }else{
          await this.getTicketsUser(this.user.id)
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