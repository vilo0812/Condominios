<template>
	<Modal>
        <template slot="header">
          <h4>{{action}} Condominio</h4>
        </template>
  
        <template slot="body">
          <v-form
            ref="form"
            v-model="valid"
            lazy-validation
          >
            <v-text-field
              v-model="name"
              :counter="30"
              :rules="nameRules"
              label="Nombre"
              required
              :value="getName"
            ></v-text-field>
            <v-select
              :items="users"
              label="Usuario"
              item-text="name"
              item-value="id"
              :rules="user_idRules"
              :value="getUser_id"
              v-model="user_id"
            ></v-select>
            <v-text-field
              v-model="description"
              :counter="30"
              :rules="descriptionRules"
              label="Descripción"
              required
              :value="getDescription"
            ></v-text-field>
            <v-text-field
              v-model="amount"
              :counter="30"
              :rules="amountRules"
              label="Monto"
              required
              :value="getAmount"
            ></v-text-field>
            <v-text-field
              v-model="dues"
              :counter="30"
              :rules="duesRules"
              label="Cuotas"
              required
              :value="getDues"
            ></v-text-field>
            <v-text-field
              v-model="location"
              :counter="30"
              :rules="locationRules"
              label="Localización"
              required
              :value="getLocation"
            ></v-text-field>
          </v-form>
        </template>
  
        <template slot="footer">
          <v-btn color="error" @click="changeModalState()">Cancelar</v-btn>
          <v-btn  :class="action == 'Actualizar' ? 'warning' : 'primary'" @click="updateOrCreateCondominios()">{{ action }}</v-btn>
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
        users:'users'
      }),
      getName() {
        return this.name = this.data != null ? this.data.name : ''
      },
      // getUser_id() {
      //   return this.user_id = this.data != null ? this.data.user_id : ''
      // },
      getUser_id() {
        return this.user_id = this.data != null ? this.data.user_id  : ''
      },
      getDescription() {
        return this.description = this.data != null ? this.data.description : ''
      },
      getAmount() {
        return this.amount = this.data != null ? this.data.amount : ''
      },
      getDues() {
        return this.dues = this.data != null ? this.data.dues : ''
      },
      getLocation() {
        return this.location = this.data != null ? this.data.location : ''
      }
  },
	components: {
      Modal
    },
  data () {
    return {
      valid: true,
      password: '',
      email: '',
      name:'',
      user_id:'',
      description:'',
      amount:'',
      dues:'',
      location:'',
      location:'',
      nameRules: [
        v => !!v || 'Nombre es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      user_idRules: [
        v => !!v || 'usuario es requerido',
      ],
      descriptionRules: [
        v => !!v || 'Descripción es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      amountRules:[
        v => !!v || 'Monto es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      duesRules:[
        v => !!v || 'Cuotas es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      locationRules:[
        v => !!v || 'Localización es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
    }
  },
  methods: {
    ...mapActions({
      updateOrCreate: 'updateOrCreateCondominios',
      setOverlay: 'setOverlay',
      getUsers: 'getUsers',
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
    async updateOrCreateCondominios() {
      this.validate()
      this.setOverlay(true)
      const condominio = {
        name : this.name,
        user_id : this.user_id,
        description : this.description,
        amount : this.amount,
        dues : this.dues,
        location : this.location,
        status : "active"
      }
      const id = this.data != null ? this.data.id : ''
      try {
        const resp = await this.updateOrCreate({ condominio,  id })
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
      if(this.users.length <= 0){
        await this.getUsers()
      }
      this.setOverlay(false)
      } catch (error) {
        console.log(error)
        this.$swal({
          icon: 'error',
          title: '¡Error al buscar Condominios!',
          confirmButtonColor: '#3085d6',
        })
        this.setOverlay(false)
      }
    },
}
</script>

<style lang="css" scoped>
</style>