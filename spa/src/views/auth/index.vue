<template>
    <v-container class="fill-height fliut">
    <v-row
      align="center"
      justify="center"
    >
      <v-col
        cols="12"
        sm="8"
        md="4"
      >
        <v-card class="elevation-2">
          <v-toolbar
            color="primary"
            dark
            flat
            dense
          >
          <v-toolbar-title>Iniciar Sesión</v-toolbar-title>
          </v-toolbar>
          <v-img
            height="300"
            src="@/assets/img/condominio.jpg"
          ></v-img>
          <v-card-text>
            <v-form @submit="login">
              <v-text-field
                v-model="form.email"
                label="Correo Electrónico"
                name="email"
                prepend-icon="mdi-account"
                type="text"
              />
              <v-text-field
                id="password"
                v-model="form.password"
                label="Contraseña"
                name="password"
                prepend-icon="mdi-lock"
                type="password"
              />
            </v-form>
          </v-card-text>
          <v-card-actions>
            <!-- <v-btn
              color="primary"
              type="submit"
              :to="{name: 'auth-register'}"
            >
              Registro
            </v-btn> -->
            <v-spacer />
            <v-btn
              color="primary"
              type="submit"
              @click="login"
            >
              Iniciar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapActions } from 'vuex'
export default {

  name: 'Login',
  data () {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async login (e) {
      e.preventDefault()
      this.setOverlay(true)
      try {
        await this.$store.dispatch('login', this.form)
        this.$router.push({ name: 'home' })
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
