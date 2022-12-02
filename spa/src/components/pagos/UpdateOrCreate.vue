<template>
	<Modal>
        <template slot="header">
          <h4>{{action}} Pago</h4>
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
            <v-select
              :items="condominios"
              label="Condominio"
              item-text="name"
              item-value="id"
              :rules="condominioRules"
              :value="getCondominio"
              v-model="condominio_id"
            ></v-select>
            <!-- <v-text-field
              v-model="status"
              :counter="60"
              :rules="statusRules"
              label="Estatus"
              required
              :value="getStatus"
            ></v-text-field> -->
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
import Modal from '@/components/base/modals'
export default {
  name: 'UpdateOrCreate',
  computed: {
    ...mapGetters({
      condominios:'condominios'
      }),
      getAmount() {
        return this.amount = this.data != null ? this.data.amount : ''
      },
      getStatus() {
        return this.status = this.data != null ? this.data.status : ''
      },
      getCondominio() {
        return this.condominio_id = this.data != null ? this.data.condominios : ''
      }
  },
	components: {
      Modal
    },
  data () {
    return {
      valid: true,
      amount: '',
      status: '',
      reference: '',
      condominio_id: '',
      name: '',
      file: null,
      amountRules: [
        v => !!v || 'Monto es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      statusRules: [
        v => !!v || 'Estatus es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      condominioRules: [
        v => !!v || 'Condominio es requerido',
      ],
    }
  },
  methods: {
    ...mapActions({
      updateOrCreate: 'updateOrCreatePagos',
      setOverlay: 'setOverlay',
      getCondominios: 'getCondominios',
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
    async updateOrCreatePago() {
      this.validate()
      this.setOverlay(true)
      var pago = new FormData();
      var status = 'pendiente'
      pago.append("reference", this.file);
      pago.append("amount", this.amount);
      pago.append("condominio_id", this.condominio_id);
      this.getStatus
      if(this.getStatus != 'pendiente'){
        pago.append("status", this.getStatus);
      }
      pago.append("status", status);
      const id = this.data != null ? this.data.id : ''
      try {
        const resp = await this.updateOrCreate({ pago,  id })
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