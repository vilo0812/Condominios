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

        <v-list>
          <v-list-item
            v-for="o in OptionsAdmin"
            :key="o.key"
            :to="{ name: o.route}"
          >
            <v-list-item-title>{{ o.name }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-btn text @click="logout">
        Cerrar Sesión
      </v-btn>
    </v-app-bar>
</template>

<script>
import { mapActions } from 'vuex'
export default {

  name: 'AppBar',

  data () {
    return {
      OptionsAdmin:[
        { key : "Usuarios", route: "Users", name : "Usuarios"},
        { key : "Tickets", route: "Tickets", name : "Tickets"},
        { key : "Condominios", route: "Condominios", name : "Urbanización"},
        { key : "Pagos", route: "Pagos", name : "Pagos"}
      ],
      OptionsUser:[
        "1",
        "2"
      ]
    }
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
