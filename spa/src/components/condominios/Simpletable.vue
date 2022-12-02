<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              Nombre
            </th>
            <th class="text-left">
              Monto
            </th>
            <th class="text-left">
              cuotas
            </th>
            <th class="text-left">
              estatus
            </th>
            <th class="text-left">
              Descripción
            </th>
            <th class="text-left">
              dirección
            </th>
            <th class="text-rigth">
              Editar
            </th>
            <!-- <th class="text-rigth">
              Eliminar
            </th> -->
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in condominios"
            :key="item.id"
          >
            <td>{{ item.name }}</td>
            <td>{{ item.amount }}</td>
            <td>{{ item.dues }}</td>
            <td>{{ item.status }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.location }}</td>
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
        condominios: 'condominios',
      }),
    },
    methods:{
      ...mapActions({
        getCondominios: 'getCondominios',
        setOverlay: 'setOverlay'
      }),
      editing: function(pago) {
        this.$emit("editing",pago);
      },
      deleting: function(pago) {
        this.$emit("deleting",pago);
      }
    },
    async created() {
      this.setOverlay(true)
      try {
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