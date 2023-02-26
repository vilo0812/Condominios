<template>
	<Modal>
        <template slot="header">
          <h4>{{action}} Anuncio</h4>
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
              label="Tema"
              required
              :value="getName"
            ></v-text-field>
            <v-text-field
              v-model="amount"
              :counter="30"
              label="Monto"
              required
              :value="getAmount"
            ></v-text-field>
            <!-- <v-select
              :items="users"
              label="Usuario"
              item-text="name"
              item-value="id"
              :rules="user_idRules"
              :value="getUser_id"
              v-model="user_id"
            ></v-select> -->
            <!-- <v-text-field
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
            ></v-text-field> -->
            <v-select
              :items="categorias"
              label="Categtoria"
              item-text="name"
              item-value="id"
              :rules="categoriesRules"
              :value="getCategoria"
              v-model="categories"
            ></v-select>
            <v-select
              :items="priorities"
              label="Prioridades"
              item-text="name"
              item-value="id"
              :value="getPriority"
              v-model="priority"
            ></v-select>
            <v-text-field
              v-model="expiration"
              :counter="30"
              :rules="expirationRules"
              label="Fecha de expiración"
              required
              :value="getExpiration"
              type="datetime-local"
            ></v-text-field>
            <v-file-input
              accept="image/png, image/jpeg"
              label="Cargar Imagen a Cartelera"
              v-model="file"
            ></v-file-input>
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
        user:'user',
        isAdmin: 'isAdmin'
      }),
      changePassword() {
        return this.action == 'Crear' ? true : false
      },
      getName() {
        return this.name = this.data != null ? this.data.issue : ''
      },
      getEmail() {
        return this.email = this.data != null ? this.data.email : ''
      },
      getUser_id() {
        return this.user_id = this.data != null ? this.data.user_id  : ''
      },
      getCategoria() {
        return this.categories = this.data != null ? this.data.categorie_id  : ''
      },
      getIssue() {
        return this.issue = this.data != null ? this.data.issue  : ''
      },
      getPriority() {
        return this.priority = this.data != null ? this.data.priority  : ''
      },
      getExpiration(){
        return this.expiration = this.data != null ? `${this.data.expiration}T00:00`  : ''
      },
      getAmount(){
        return this.amount = this.data != null ? this.data.amount  : ''
      },
      getTicket_id() {
        return this.ticket_id = this.data != null ? this.data.id : ''
      },
  },
	components: {
      Modal
    },
  data () {
    return {
      valid: true,
      user_id : '',
      name : '',
      categories : 0,
      priority : '',
      issue : '',
      ticket_id : '',
      file: null,
      amount: '',
      expiration: null,
      status : 0,
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
      nameRules: [
        v => !!v || 'Nombre es requerido',
        v => (v && v.length <= 100) || 'deben ser menos de 30 caracteres',
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
        v => v == '' || 'prioridad es requerido',
      ],
      expirationRules:[
      v => !!v || 'Fecha de expiración es requerido',
      ],
      amountRules:[
      v => !!v || 'Monto es requerido',
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
      this.categories = 0
      this.priority = ''
      this.issue = ''
      this.$emit('close')
    },
    async updateOrCreateTickets() {
      this.validate()
      this.setOverlay(true)
      const id = this.data != null ? this.data.id : ''
      let userId = String.valueOf(this.user_id)
      var ticket = new FormData();
      ticket.append("user_id", this.user.id);
      ticket.append("name", this.name);
      if(id == null){
        ticket.append("email", this.email);
      }
      ticket.append("categorie_id", this.categories);
      ticket.append("priority", this.priority);
      ticket.append("issue", this.name);
      if(id != null){
        ticket.append("ticket_id", id);
      }
      ticket.append("status", this.status);
      ticket.append("expiration", this.expiration);
      ticket.append("amount", this.amount);
      ticket.append("file", this.file);
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