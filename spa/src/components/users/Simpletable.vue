<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left w-50">
              Nombre
            </th>
            <th class="text-left w-50">
              Correo
            </th>
            <th class="text-left w-50">
              Teléfono
            </th>
            <th class="text-left w-50">
              Apartamento
            </th>
            <th class="text-right">
              Editar
            </th>
            <th class="text-right">
              Eliminar
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in users"
            :key="item.id"
          >
            <td>{{ item.name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.phone }}</td>
            <td>{{ item.direction }}</td>
            <td class="text-right"> 
                <v-btn
                  depressed
                  color="warning"
                  @click="editing(item)"
                >
                  Editar
                </v-btn>
            </td>
            <td class="text-right"> 
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
    }),
    computed: {
      ...mapGetters({
        users: 'users',
      }),
    },
    methods:{
      ...mapActions({
        getUsers: 'getUsers',
        setOverlay: 'setOverlay'
      }),
      editing: function(user) {
        this.$emit("editing",user);
      },
      deleting: function(user) {
        this.$emit("deleting",user);
      }
    },
    async created() {
      this.setOverlay(true)
      try {
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
    }
  }
</script>

<style>

</style>