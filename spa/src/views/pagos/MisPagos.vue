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
              Pagos Realizados
            </v-card-title>
            <a
                style="text-decoration: none;color:white;background: rgb(33, 150, 210);border-radius: 10px;padding: 10px;margin: 5px;"
                class="Button"
                :href="getHref(user.id,'activo')"
              >
                <span class="v-btn content"> Pagos Pendientes </span>
            </a>
            <a
                style="text-decoration: none;color:white;background: rgb(33, 150, 210);border-radius: 5px;padding: 10px; margin: 5px;"
                class="Button"
                :href="getHref(user.id,'aprobado')"
              >
                <span class="v-btn content"> Pagos Aprobados </span>
            </a>
            <Simpletable style=" margin-top: 10px;" @editing="editing" @deleting="deleting" @seeing="seeing"/>
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
    import Simpletable from '@/components/pagos/SimpletableMisPagos.vue'
    import UpdateOrCreate from '@/components/pagos/UpdateOrCreate.vue'
    import DeleteModal from '@/components/base/modals/DeleteModal.vue'
    import ImageModal from '@/components/base/modals/ImageModal.vue'
    import { mapGetters } from 'vuex'
    export default {
      name: 'MisPagos',
      data () {
        return {
          action : '',
          pago: null
        }
      },
      computed: {
        ...mapGetters({
          user: 'user'
        })
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
        getHref(user_id,estatus){
          let url = null;
          if (process.env.NODE_ENV === 'production' && process.env.VUE_APP_API_URL) {
            url = `${process.env.VUE_APP_API_URL}`
          } else {
            url = `${process.env.VUE_APP_BASE_URL}`
          }
          return `${url}/api/excel/pago?status=${estatus}&user_id=${user_id}`

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
          console.log(pago)
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