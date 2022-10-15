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
            <!-- <v-text-field
              v-model="gadget"
              :counter="30"
              :rules="nombreRules"
              label="Nombre"
              required
              :value="getGadget"
            ></v-text-field> -->
            <v-select
              label="Correo"
              item-text="mail"
            ></v-select>
            <!-- :items="departaments"
              :rules="departamentsRules"
              :value="getDepartament"
              v-model="departament_id" -->
            <!-- <v-select
              :items="statusList"
              label="Estatus"
              item-text="name"
              item-value="id"
              :rules="statusRules"
              :value="getStatus"
              v-model="status"
            ></v-select> -->
          </v-form>
        </template>
  
        <template slot="footer">
          <!-- <v-btn color="error" @click="changeModalState()">Cancelar</v-btn>
          <v-btn  :class="action == 'Actualizar' ? 'warning' : 'primary'" @click="updateOrCreateGadget()">{{ action }}</v-btn> -->
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
  },
	components: {
      Modal
    },
  data () {
    return {
      valid: true,
    }
  },
  methods: {
  },
  props: {
    action: '',
    data: null
  }
}
</script>

<style lang="css" scoped>
</style>