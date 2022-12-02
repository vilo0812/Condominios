<template>
    <v-row justify="center">
        <v-dialog
          v-model="modalImageState"
          persistent
          max-width="600px"
        >
          <v-card>
            <v-card-title class="headline">
                <h4>Recibo de {{ moduleName }}</h4>
                <v-spacer></v-spacer>
                <v-btn
                  @click="changeModalState(false)"
                  color="error"
                  fab
                  dark
                  small
                >
                  <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
              <v-img
              :src="getUrl"
              >
              </v-img>
            <v-card-actions>

                <v-btn color="primary" @click="changeModalState(false)">Cancelar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
    </v-row>
  </template>
  
  <script>
  import { mapGetters } from 'vuex'
  import Modal from '@/components/base/modals'
  export default {
    computed: {
      ...mapGetters({
        modalImageState: 'modalImageState'
      }),
      getUrl() {
        return this.url = this.data.reference != null ? this.data.reference : ''
      }
    },
    name: 'ImageModal',
     props: {
      data: {
        required: true
      },
      moduleName: {
        type: String,
        required: true
      }
     },
     components: {
        Modal,
      },
    data () {
      return {
        url : ''
      }
    },
    methods: {
      changeModalState(state) {
        this.$store.commit('CHANGE_MODAL_IMAGE_STATE', state)
      }
    }
  }
  </script>
  
  <style lang="css" scoped>
  </style>