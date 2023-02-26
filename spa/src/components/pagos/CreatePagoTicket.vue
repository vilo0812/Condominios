<template>
	<Modal>
        <template slot="header">
          <h4>{{action}} Pago </h4>
        </template>

        <template slot="body">
          <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            enctype="multipart/form-data"
          >
            <v-text-field
              v-model="amount"
              :counter="30"
              :rules="amountRules"
              label="Monto"
              required
              :value="getAmount"
            ></v-text-field>
            <!-- <v-select
              :items="condominios"
              label="Condominio"
              item-text="name"
              item-value="id"
              :rules="condominioRules"
              :value="getCondominio"
              v-model="condominio_id"
            ></v-select> -->
            <v-text-field
              :counter="30"
              v-model="fecha_pago"
              label="Fecha de Pago"
              required
              type="datetime-local"
            ></v-text-field>
            <v-file-input
              accept="image/png, image/jpeg"
              label="Cargar pago"
              v-model="file"
            ></v-file-input>
          </v-form>
        </template>
        <template slot="footer">
          <v-btn color="error" @click="changeModalState()">Cancelar</v-btn>
          <v-btn :class="action == 'Actualizar' ? 'warning' : 'primary'" @click="updateOrCreatePago($event)">{{ action }}</v-btn>
        </template>
    </Modal>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import Modal from '@/components/base/modals/CreatePagoTicketModal'
export default {
  name: 'UpdateOrCreate',
  computed: {
    ...mapGetters({
      condominios:'condominios',
      pagos: 'pagos',
      user:'user'
      }),
      getAmount() {
        return this.amount = this.data != null ? this.data.amount : ''
      },
      getStatus() {
        return this.status = this.data != null ? this.data.status : ''
      }
    //   getCondominio() {
    //     return this.condominio_id = this.data != null ? this.data.condominios : ''
    //   }
  },
	components: {
      Modal
    },
  data () {
    return {
      valid: true,
      amount: '',
      status: 'activo',
      reference: '',
      condominio_id: '',
      name: '',
      fecha_pago: '',
      file: null,
      amountRules: [
        v => !!v || 'Monto es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      statusRules: [
        v => !!v || 'Estatus es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ]
    //   condominioRules: [
    //     v => !!v || 'Condominio es requerido',
    //   ],
    }
  },
  methods: {
    ...mapActions({
      updateOrCreate: 'updateOrCreatePagos',
      setOverlay: 'setOverlay',
      getCondominios: 'getCondominios',
      getPagos: 'getPagos'
    }),
    validate () {
      this.$refs.form.validate()
    },
    changeModalState() {
      this.password = ''
      this.email = ''
      this.name = ''
      this.$emit('close')
    },
    GetPagoId: function(ticket_id) {
      let response = 0;
        let pago = null;
        this.pagos.forEach( (p) =>{
          if(p.user_id ==  this.user.id
          && p.support_id == ticket_id
          ){
            pago = p;
          }
        });
        if(pago != null){
          response = pago.id
        }
        return response;
      },
    async updateOrCreatePago() {
      this.validate()
      this.setOverlay(true)
      var pago = new FormData();
      var status = 'pendiente'
      pago.append("reference", this.file);
      pago.append("amount", this.amount);
      pago.append("user_id", this.user.id);
      pago.append("support_id", this.data.id);
      pago.append("fecha_pago", this.fecha_pago);
      pago.append("status", "activo");
      let id = this.GetPagoId(this.data.id)
      console.log(id)
      try {
        const resp = await this.updateOrCreate({pago, id})
        this.$swal({
            icon: 'success',
            title: '¡Exito!',
            confirmButtonColor: '#3085d6',
          })
        this.changeModalState()
        this.setOverlay(false)
      } catch (error) {
          console.log(error)
          this.$swal({
            icon: 'error',
            title: '¡Error con los registros!',
            confirmButtonColor: '#3085d6',
          })
          this.changeModalState()
          this.setOverlay(false)
      }
    },
  },
  props: {
    action: '',
    data: null
  },
  async created() {
      this.setOverlay(true)
      try {
      await this.getCondominios()
      await this.getPagos()
      this.setOverlay(false)
      } catch (error) {
        console.log(error)
        this.$swal({
          icon: 'error',
          title: '¡Error al buscar Usuarios!',
          confirmButtonColor: '#3085d6',
        })
        this.setOverlay(false)
      }
    },
}
</script>

<style lang="css" scoped>
</style>