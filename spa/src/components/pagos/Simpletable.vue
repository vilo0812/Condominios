<template>
    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">
              Condominio
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
              Eliminar pago
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in pagos"
            :key="item.id"
          >
            <td>{{ getCondominio(item.condominio_id) }}</td>
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
            <!-- <td class="text-right">
                <v-btn
                  depressed
                  color="warning"
                  @click="editing(item)"
                >
                  Editar
                </v-btn>
            </td> -->
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
    }),
    computed: {
      ...mapGetters({
        pagos: 'pagos',
        condominios: 'condominios',
      })
    },
    methods:{
      ...mapActions({
        getPagos: 'getPagos',
        getCondominios: 'getCondominios',
        setOverlay: 'setOverlay'
      }),
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
        if(this.pagos.length <= 0){
          await this.getPagos()
        }
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