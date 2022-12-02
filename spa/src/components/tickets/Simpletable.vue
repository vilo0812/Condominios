<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              Usuario
            </th>
            <th class="text-left">
              Ticket
            </th>
            <th class="text-left">
              Categoria
            </th>
            <th class="text-left">
              Prioridad
            </th>
            <th class="text-left">
              Tema
            </th>
            <th class="text-rigth">
              Editar
            </th>
            <th class="text-rigth">
              Eliminar
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in tickets"
            :key="item.id"
          >
            <td>{{ getUser(item.user_id) }}</td>
            <td>{{ item.name }}</td>
            <td>{{ getCategories(item.categories) }}</td>
            <td>{{ item.priority }}</td>
            <td>{{ item.issue }}</td>
            <td class="text-left"> 
                <v-btn
                  depressed
                  color="warning"
                  @click="editing(item)"
                >
                  Editar
                </v-btn>
            </td>
            <td class="text-left"> 
                <v-btn
                  depressed
                  color="error"
                  @click="deleting(item)"
                >
                  Eliminar
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
        {id: 0,name:"Ayuda"},
        {id: 1,name:"Soporte técnico"},
        {id: 2,name:"Retraso de pago"},
        {id: 3,name:"Corrección de datos"},
        {id: 4,name:"Bono"},
        {id: 5,name:"inversion total"}
      ],
    }),
    computed: {
      ...mapGetters({
        tickets: 'tickets',
        isAdmin: 'isAdmin',
        users: 'users',
        user: 'user'
      }),
    },
    methods:{
      ...mapActions({
        getUsers: 'getUsers',
        getTicketsAdmin: 'getTicketsAdmin',
        getTicketsUser: 'getTicketsUser',
        setOverlay: 'setOverlay'
      }),
      editing: function(user) {
        this.$emit("editing",user);
      },
      deleting: function(user) {
        this.$emit("deleting",user);
      },
      getUser(id){
        let UserTake;
        this.users.forEach( (c) =>{
          if(c.id == id){
            UserTake = c.name;
          }
        });
        if(id == 1){
          UserTake = this.user.name;
        }
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
        if(this.isAdmin){
          await this.getTicketsAdmin()
        }else{
          await this.getTicketsUser()
        }
        // if(this.tickets.length <= 0){
        //   await this.getTicketsAdmin()
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