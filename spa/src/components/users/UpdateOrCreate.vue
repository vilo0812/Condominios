<template>
	<Modal>
        <template slot="header">
          <h4>{{action}} Usuario</h4>
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
            <v-text-field
              v-model="email"
              :counter="60"
              :rules="emailRules"
              label="Correo"
              required
              :value="getEmail"
            ></v-text-field>
            <v-text-field
              v-if="changePassword"
              v-model="password"
              :counter="30"
              :rules="passwordRules"
              label="Contraseña"
              required
            ></v-text-field>
          </v-form>
        </template>
  
        <template slot="footer">
          <v-btn color="error" @click="changeModalState()">Cancelar</v-btn>
          <v-btn  :class="action == 'Actualizar' ? 'warning' : 'primary'" @click="updateOrCreateUser()">{{ action }}</v-btn>
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
      changePassword() {
        return this.action == 'Crear' ? true : false
      },
      getName() {
        return this.name = this.data != null ? this.data.name : ''
      },
      getEmail() {
        return this.email = this.data != null ? this.data.email : ''
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
      nameRules: [
        v => !!v || 'Nombre es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ],
      emailRules: [
        v => !!v || 'Correo es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 60 caracteres',
      ],
      passwordRules: [
        v => !!v || 'Correo es requerido',
        v => (v && v.length <= 30) || 'deben ser menos de 30 caracteres',
      ]
    }
  },
  methods: {
    ...mapActions({
      updateOrCreate: 'updateOrCreateUsers',
      setOverlay: 'setOverlay'
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
    async updateOrCreateUser() {
      this.validate()
      this.setOverlay(true)
      const user = {
        name : this.name,
        password : this.password,
        email : this.email,
        rol : ''
      }
      const id = this.data != null ? this.data.id : ''
      try {
        const resp = await this.updateOrCreate({ user,  id })
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
  }
}
</script>

<style lang="css" scoped>
</style>