<template>
  <div class="w-full">
    <!-- <loading /> -->
    <nav class="nav" v-show="$route.name != 'unauthorized'">
      <div class="container">
        <div class="nav__wrapper">
          <div class="logo" @click.prevent="$router.push('/')">
            <img src="/images/pepo-logo.png" alt="" />
          </div>
          <div class="logout"  @click.prevent="logout" v-if="$route.name != 'auth'">
              <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 384.971 384.971" style="enable-background:new 0 0 384.971 384.971;" xml:space="preserve"><g><g id="Sign_Out"><path d="M180.455,360.91H24.061V24.061h156.394c6.641,0,12.03-5.39,12.03-12.03s-5.39-12.03-12.03-12.03H12.03C5.39,0.001,0,5.39,0,12.031V372.94c0,6.641,5.39,12.03,12.03,12.03h168.424c6.641,0,12.03-5.39,12.03-12.03C192.485,366.299,187.095,360.91,180.455,360.91z"/><path d="M381.481,184.088l-83.009-84.2c-4.704-4.752-12.319-4.74-17.011,0c-4.704,4.74-4.704,12.439,0,17.179l62.558,63.46H96.279c-6.641,0-12.03,5.438-12.03,12.151c0,6.713,5.39,12.151,12.03,12.151h247.74l-62.558,63.46c-4.704,4.752-4.704,12.439,0,17.179c4.704,4.752,12.319,4.752,17.011,0l82.997-84.2C386.113,196.588,386.161,188.756,381.481,184.088z"/></g><g></g><g></g><g></g><g></g><g></g><g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
          <a href="#">Logout</a>
          </div>
        </div>
      </div>
    </nav>
    <router-view></router-view>
    <footer v-show="$route.name != 'unauthorized'">All Copyright reserved to PepoSc</footer>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
        localStorage.removeItem('token')
        this.$router.push('/')
      console.log("logout");
    },
  }
};
</script>