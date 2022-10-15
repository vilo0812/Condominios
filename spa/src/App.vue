<template>
  <v-app>
    <div class="body">
      <overlay/>
      <router-view name="header" />
          <router-view class="pt-5"/>
      <router-view name="footer" />
    </div>
  </v-app>
</template>

<script>
import overlay from '@/components/base/overlay'
export default {
  name: 'App',
  components: {
    overlay
  }
}
</script>
<style>
.body {
  min-height: 700px;
  background-color: #000;
    background-image: url("./assets/img/bg.jpg");
    background-size: cover;
    background-position: top center;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen',
    'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue',
    sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;

}
</style>
