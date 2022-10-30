<template>
    <div>
      <v-row
      align="center"
      justify="center"
      >
        <v-col
        cols="12"
        sm="9"
        >
          <v-card 
            class="elevation-2"
            color="deep-purple accent-4"
          >
            <v-card-title>
              Usuarios
              <v-spacer />
              <v-btn
                color="primary"
                large
              @click="changeModalState(true, 'Crear')"
              >
                Agregar Usuario
              </v-btn>
            </v-card-title>
            <Simpletable  @editing="editing" @deleting="deleting"/>
          </v-card>
        </v-col>
      </v-row>
      <!--   Modal Update Or Create User -->
      <UpdateOrCreate :action="action" :data="user" @close="close"/>
      <!--   Modal Delete User -->
      <DeleteModal :data="user" module-name="Usuario" action-delete-name="deleteUser"/>
    </div>
  </template>
  
  <script>
    import Simpletable from '@/components/users/Simpletable.vue'
    import UpdateOrCreate from '@/components/users/UpdateOrCreate.vue'
    import DeleteModal from '@/components/base/modals/DeleteModal.vue'
    export default {
      name: 'Users',
      data () {
        return {
          action : '',
          user: null
        }
      },
      components: {
        Simpletable,
        UpdateOrCreate,
        DeleteModal
      },
      methods: {
        changeModalState(state, action = null) {
          this.user = null
          this.action = action
          this.$store.commit('CHANGE_MODAL_STATE', state)
        },
        editing(user){
          this.changeModalState(true, 'Editar')
          this.user = user
        },
        deleting(user){
          this.user = user
          this.$store.commit('CHANGE_MODAL_DELETE_STATE', true)
        },
        close(){
          this.user = null
          this.action = null
          this.$store.commit('CHANGE_MODAL_STATE', false)
        },
      }
    }
  </script>
  
  <style>
  
  </style>