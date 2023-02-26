<template>
	<v-app-bar
      color="deep-purple accent-4"
      dense
      dark
    >
      <v-toolbar-title>Urb. Romulo Gallegos</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
          text
            v-bind="attrs"
            v-on="on"
          >
            Modulos
          </v-btn>
        </template>
        <template v-if="isAdmin">
          <v-list >
          <v-list-item
            v-for="o in OptionsAdmin"
            :key="o.key"
            :to="{ name: o.route}"
          >
            <v-list-item-title>{{ o.name }}</v-list-item-title>
          </v-list-item>
        </v-list>
        </template>
        <template v-else>
          <v-list >
          <v-list-item
            v-for="o in OptionsUser"
            :key="o.key"
            :to="{ name: o.route}"
          >
            <v-list-item-title>{{ o.name }}</v-list-item-title>
          </v-list-item>
        </v-list>
        </template>
      </v-menu>
      <v-btn text @click="logout">
        Cerrar Sesión
      </v-btn>
    </v-app-bar>
</template>

<script>
import { mapActions,mapGetters } from 'vuex'
export default {

  name: 'AppBar',

  data () {
    return {
      OptionsAdmin:[
        { key : "Usuarios", route: "Users", name : "Usuarios"},
        { key : "Tickets", route: "Tickets", name : "Anuncios"},
        { key : "Pagos", route: "Pagos", name : "Pagos"}
      ],
      OptionsUser:[
        { key : "Tickets", route: "Tickets", name : "Anuncios"},
        { key : "MisPagos", route: "MisPagos", name : "Pagos"}
      ]
    }
  },
  computed: {
    ...mapGetters({
      isAdmin: 'isAdmin'
    }),
  },
  methods: {
    async logout () {
      this.setOverlay(true)
      try {
        const resp = await this.$store.dispatch('logout')
        console.log(resp)
        this.$router.push({ name: 'auth-login' })
        this.setOverlay(false)
      } catch (error) {
        this.setOverlay(false)
        console.log(error)
      }
    },
    async fetchUser () {
      this.setOverlay(true)
      try {
        await this.$store.dispatch('fetchUser')
        this.setOverlay(false)
      } catch (error) {
        this.setOverlay(false)
        console.log(error)
      }
    },
    ...mapActions({
      setOverlay: 'setOverlay'
    })
  }
}
</script>

<style lang="css" scoped>
</style>
