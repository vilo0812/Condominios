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
              Pagos
              <v-spacer />
              <v-btn
                color="primary"
                large
              @click="changeModalState(true, 'Crear')"
              >
                Agregar Pago
              </v-btn>
            </v-card-title>
            <Simpletable  @editing="editing" @deleting="deleting" @seeing="seeing"/>
          </v-card>
        </v-col>
      </v-row>
      <!--   Modal Update Or Create Pago -->
      <UpdateOrCreate :action="action" :data="pago" @close="close"/>
      <!--   Modal Delete Pago -->
      <DeleteModal :data="pago" module-name="Pago" action-delete-name="deletePago"/>
      <!--   Modal Image Pago -->
      <ImageModal :data="pago" module-name="Pago"/>
    </div>
  </template>
  
  <script>
    import Simpletable from '@/components/pagos/Simpletable.vue'
    import UpdateOrCreate from '@/components/pagos/UpdateOrCreate.vue'
    import DeleteModal from '@/components/base/modals/DeleteModal.vue'
    import ImageModal from '@/components/base/modals/ImageModal.vue'
    export default {
      name: 'Pago',
      data () {
        return {
          action : '',
          pago: null
        }
      },
      components: {
        Simpletable,
        UpdateOrCreate,
        DeleteModal,
        ImageModal
      },
      methods: {
        changeModalState(state, action = null) {
          this.pago = null
          this.action = action
          this.$store.commit('CHANGE_MODAL_STATE', state)
        },
        editing(pago){
          this.changeModalState(true, 'Editar')
          this.pago = pago
        },
        deleting(pago){
          this.pago = pago
          this.$store.commit('CHANGE_MODAL_DELETE_STATE', true)
        },
        seeing(pago){
          this.pago = pago
          this.$store.commit('CHANGE_MODAL_IMAGE_STATE', true)
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