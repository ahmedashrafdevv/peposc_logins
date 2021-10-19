<template>
  <div class="container">
    <div v-if="loading"><loading /></div>
    <div v-else-if="users.length == 0">
      <h2 class="text-center">No users yet</h2>
      <a href="#" @click.prevent="getUsers" class="button text-center">
        <svg
          height="50px"
          id="SVGRoot"
          version="1.1"
          viewBox="0 0 16 16"
          width="50px"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:cc="http://creativecommons.org/ns#"
          xmlns:dc="http://purl.org/dc/elements/1.1/"
          xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
          xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
          xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
          xmlns:svg="http://www.w3.org/2000/svg"
        >
          <defs id="defs37" />
          <g id="layer1">
            <path
              d="M 7.9375,1.625 A 6.03125,6.03125 0 0 0 2.5585938,4.9375 H 4.2246094 A 4.6081461,4.6081461 0 0 1 7.9375,3.0488281 4.6081461,4.6081461 0 0 1 12.474609,6.8769531 L 11.1875,6.875 12.154297,8.5585938 13.119141,10.240234 14.09375,8.5625 15.068359,6.8847656 13.912109,6.8808594 A 6.03125,6.03125 0 0 0 7.9375,1.625 Z M 3.1328125,5.8125 2.1582031,7.4902344 1.1835938,9.1679688 l 1.15625,0.00391 a 6.03125,6.03125 0 0 0 5.9746093,5.255859 6.03125,6.03125 0 0 0 5.3789059,-3.3125 H 12.027344 A 4.6081461,4.6081461 0 0 1 8.3144531,13.003906 4.6081461,4.6081461 0 0 1 3.7773438,9.1757812 l 1.2871093,0.00195 -0.9667969,-1.6835938 z"
              id="path53"
              style="fill: #fff; stroke: none; stroke-width: 1.08426964"
            />
          </g>
        </svg>
        Retry
      </a>
    </div>
    <div v-else>
      <h2 class="text-center">Please approve or decline these users</h2>
      <table>
        <tr>
          <th>Id</th>
          <th>Email</th>
          <th>Name</th>
          <th>Status</th>
          <th>Date</th>
          <th>actions</th>
        </tr>
        <tr v-for="user in users" :key="user.email">
          <td>{{ user.id }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.status }}</td>
          <td>{{ user.created_at }}</td>
          <td class="flex justify-center">
            <div class="buttons">
              <a
                href="#"
                @click.prevent="verify(user.id, 'declined')"
                :class="`button danger ${verifyLoading ? 'btn-loading' : ''}`"
              >
                <!-- <div class="lds-ellipsis" v-if="verifyLoading"><div></div><div></div><div></div><div></div></div> -->
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><metadata>  Svg Vector Icons : http://www.onlinewebfonts.com/icon</metadata><g>  <path    d="M500.4,990c-89.9,0-177.8-24.6-254.4-71c-11.9-7.3-15.8-22.9-8.5-34.8c4.7-7.6,12.9-12.2,21.8-12.2c4.6,0,9.1,1.3,13,3.7c68.5,41.7,147.3,63.7,227.9,63.7c20.8,0,41.7-1.5,62.2-4.4c239.7-34.4,406.7-257.4,372.3-497.2c-16.7-116.1-77.6-218.8-171.5-289.1C686.7,91.1,596,60.8,501,60.8c-21,0-42.4,1.5-63.4,4.6c-58.6,8.4-113.9,28.1-164.2,58.5c-48.6,29.4-90.6,67.4-124.8,113.1c-34.2,45.7-58.9,96.7-73.4,151.6c-15,56.9-18.4,115.4-9.9,174c9,62.8,30.9,121.5,64.9,174.3c7.6,11.8,4.2,27.5-7.6,35c-4.1,2.7-8.9,4.1-13.7,4.1c-8.7,0-16.7-4.3-21.3-11.6c-38-59.1-62.3-124.5-72.4-194.6C-3.5,440.2,29.5,311.2,108,206.5c14.1-18.9,29.7-37,46.4-53.6c75-75,170.4-122.6,276.2-137.8c23.4-3.4,47.2-5.1,70.6-5.1c105.9,0,207.1,33.9,292.6,97.9c104.7,78.5,172.7,193,191.3,322.5c38.4,267.4-147.9,516.2-415.3,554.6C546.9,988.3,523.5,990,500.4,990z"  />  <path    d="M683.3,700.4c-6.8,0-13.2-2.6-17.9-7.4L503.2,530.2l-161,159.2c-4.8,4.7-11.1,7.3-17.8,7.3c-6.8,0-13.2-2.7-18-7.5c-9.8-9.9-9.7-26,0.2-35.8l160.8-159.1l-159.5-160c-4.8-4.8-7.4-11.2-7.4-17.9c0-6.8,2.7-13.1,7.4-17.9c4.8-4.8,11.1-7.4,17.9-7.4c6.8,0,13.2,2.7,18,7.5l159.7,160.2l162.1-160.3c4.8-4.7,11.1-7.3,17.8-7.3c6.8,0,13.2,2.7,18,7.5c9.8,10,9.7,26-0.2,35.8L539.3,494.6l162,162.6c9.9,9.9,9.8,26,0,35.8C696.4,697.8,690.1,700.4,683.3,700.4z"  /></g></svg>
                decline
              </a>
              <a
                href="#"
                @click.prevent="verify(user.id, 'approved')"
                :class="`button success ${verifyLoading ? 'btn-loading' : ''}`"
              >
                <!-- <div class="lds-ellipsis" v-if="verifyLoading"><div></div><div></div><div></div><div></div></div> -->
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 330 330" style="enable-background: new 0 0 330 330" xml:space="preserve"><g>  <path    d="M165,0C74.019,0,0,74.019,0,165s74.019,165,165,165s165-74.019,165-165S255.981,0,165,0z M165,300c-74.44,0-135-60.561-135-135S90.56,30,165,30s135,60.561,135,135S239.439,300,165,300z"  />  <path    d="M226.872,106.664l-84.854,84.853l-38.89-38.891c-5.857-5.857-15.355-5.858-21.213-0.001c-5.858,5.858-5.858,15.355,0,21.213l49.496,49.498c2.813,2.813,6.628,4.394,10.606,4.394c0.001,0,0,0,0.001,0c3.978,0,7.793-1.581,10.606-4.393l95.461-95.459c5.858-5.858,5.858-15.355,0-21.213C242.227,100.807,232.73,100.806,226.872,106.664z"  /></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                approve
              </a>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script>
import { getUsers, verify } from "../Api";
import Loading from "../components/Loading.vue";
export default {
  data() {
    return {
      loading: true,
      verifyLoading: false,
      status: "pending",
      users: [],
    };
  },
  components: {
    Loading,
  },
  methods: {
    verify(id, status) {
      this.verifyLoading = true
      verify(id, status)
        .then(() => {
          this.verifyLoading = false
          setTimeout(() => {
            this.users = this.users.filter(user => {
              return user.id != id ? user : null
            })
          }, 100);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    getUsers() {
      getUsers(this.status)
        .then((res) => {
          this.users = res;
          setTimeout(() => {
            this.loading = false;
          }, 100);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {
    this.getUsers();
  },
};
</script>