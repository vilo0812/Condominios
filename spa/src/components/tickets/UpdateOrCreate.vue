<template>
	<Modal>
        <template slot="header">
          <h4>{{action}} Ticket</h4>
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
              v-model="issue"
              :counter="30"
              :rules="temaRules"
              label="Tema"
              required
              :value="getIssue"
            ></v-text-field>
            <v-text-field
              v-model="priority"
              :counter="30"
              :rules="priorityRules"
              label="Prioridad"
              required
              :value="getPriority"
            ></v-text-field>
            <v-select
              :items="categorias"
              label="Categtoria"
              item-text="name"
              item-value="id"
              :rules="categoriesRules"
              :value="getCategoria"
              v-model="categories"
            ></v-select>
          </v-form>
        </template>
  
        <template slot="footer">
          <v-btn color="error" @click="changeModalState()">Cancelar</v-btn>
          <v-btn  :class="action == 'Actualizar' ? 'warning' : 'primary'" @click="updateOrCreateTickets()">{{ action }}</v-btn>
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
        users:'users',
        isAdmin: 'isAdmin'
      }),
      changePassword() {
        return this.action == 'Crear' ? true : false
      },
      getName() {
        return this.name = this.data != null ? this.data.name : ''
      },
      getEmail() {
        return this.email = this.data != null ? this.data.email : ''
      },
      getUser_id() {
        return this.user_id = this.data != null ? this.data.user_id  : ''
      },
      getCategoria() {
        return this.categories = this.data != null ? this.data.categories  : ''
      },
      getIssue() {
        return this.issue = this.data != null ? this.data.issue  : ''
      },
      getPriority() {
        return this.priority = this.data != null ? this.data.priority  : ''
      }
  },
	components: {
      Modal
    },
  data () {
    return {
      valid: true,
      user_id : '',
      name : '',
      categories : '',
      priority : '',
      issue : '',
      ticket_id : '',
      categorias : [
        {id: 0,name:"Ayuda"},
        {id: 1,name:"Soporte técnico"},
        {id: 2,name:"Retraso de pago"},
        {id: 3,name:"Corrección de datos"},
        {id: 4,name:"Bono"},
        {id: 5,name:"inversion total"}
      ],
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
      ],
      user_idRules: [
        v => !!v || 'usuario es requerido',
      ],
      categoriesRules: [
        v => !!v || 'categoria es requerido',
      ],
      temaRules: [
        v => !!v || 'tema es requerido',
      ],
      priorityRules: [
        v => !!v || 'prioridad es requerido',
      ],
    }
  },
  methods: {
    ...mapActions({
      updateOrCreateTicketsAdmin: 'updateOrCreateTicketsAdmin',
      updateOrCreateTicketsUser: 'updateOrCreateTicketsUser',
      getUsers: 'getUsers',
      setOverlay: 'setOverlay'
    }),
    validate () {
      this.$refs.form.validate()
    },
    changeModalState() {
      this.user_id = ''
      this.name = ''
      this.categories = ''
      this.priority = ''
      this.issue = ''
      this.$emit('close')
    },
    async updateOrCreateTickets() {
      this.validate()
      this.setOverlay(true)
      const id = this.data != null ? this.data.id : ''
      let userId = String.valueOf(this.user_id)
      const ticket = {
        user_id : userId,
        name : this.name,
        categorie : String.valueOf(this.categories),
        priority : String.valueOf(this.priority),
        issue : String.valueOf(this.issue),
        ticket_id : String.valueOf(id),
        status : "0"
      }
      try {
        if(this.isAdmin){
          const resp = await this.updateOrCreateTicketsAdmin({ ticket,  id })
        }else{
          const resp = await this.updateOrCreateTicketsUser({ ticket,  id })
        }
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
          title: '¡Error al buscar Tickets!',
          confirmButtonColor: '#3085d6',
        })
        this.setOverlay(false)
      }
    },
  props: {
    action: '',
    data: null
  }
}
</script>

<style lang="css" scoped>
</style>