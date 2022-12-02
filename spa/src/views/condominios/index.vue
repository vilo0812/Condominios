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
              Urbanización
              <v-spacer />
              <!-- <v-btn
                color="primary"
                large
              @click="changeModalState(true, 'Crear')"
              >
                Agregar Condominios
              </v-btn> -->
            </v-card-title>
            <Simpletable  @editing="editing" @deleting="deleting"/>
          </v-card>
        </v-col>
      </v-row>
      <!--   Modal Update Or Create User -->
      <UpdateOrCreate :action="action" :data="condominio" @close="close"/>
      <!--   Modal Delete User -->
      <DeleteModal :data="condominio" module-name="Condominio" action-delete-name="deleteCondominio"/>
    </div>
  </template>
  
  <script>
    import Simpletable from '@/components/condominios/Simpletable.vue'
    import UpdateOrCreate from '@/components/condominios/UpdateOrCreate.vue'
    import DeleteModal from '@/components/base/modals/DeleteModal.vue'
    export default {
      name: 'Condominios',
      data () {
        return {
          action : '',
          condominio: null
        }
      },
      components: {
        Simpletable,
        UpdateOrCreate,
        DeleteModal
      },
      methods: {
        changeModalState(state, action = null) {
          this.condominio = null
          this.action = action
          this.$store.commit('CHANGE_MODAL_STATE', state)
        },
        editing(condominio){
          this.changeModalState(true, 'Editar')
          this.condominio = condominio
        },
        deleting(condominio){
          this.condominio = condominio
          this.$store.commit('CHANGE_MODAL_DELETE_STATE', true)
        },
        close(){
          this.condominio = null
          this.action = null
          this.$store.commit('CHANGE_MODAL_STATE', false)
        },
      }
    }
  </script>
  
  <style>
  
  </style>