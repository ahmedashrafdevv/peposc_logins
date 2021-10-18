<template>
  <div class="container">
    <div v-if="loading">loading</div>
    <div v-else-if="userInfo.status == 'pending'">
      <h2>
        Your account is on pending status it will be approved from one of our team
        shortly
      </h2>
      <a href="#" class="button" @click.prevent="getUser()">
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
     <div v-else-if="userInfo.status == 'declined'">
      <h2>
        Sorry ! your request was declined
      </h2>
     </div>
    <div v-else>
      <h2>Hello to peposc</h2>
      <ul>
        <li v-for="key in Object.keys(userInfo)" :key="key">
          {{ key }} : {{ userInfo[key] }}
        </li>
      </ul>

      <h2>
        you have logged in {{ userInfo.logins.length }} (time/s) to our system
      </h2>
      <h2>your logins history</h2>
      <table>
        <tr>
          <th>Date</th>
          <th>Time</th>
        </tr>
        <tr v-for="login in userInfo.logins" :key="login.id">
          <td>{{ login.created_at }}</td>
          <td>{{ login.updated_at }}</td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script>
import {getUser} from "../Api";
export default {
  data() {
    return {
      loading: true,
      userInfo: {},
    };
  },
  methods:{
    me(){
      getUser()
      .then((res) => {
        this.userInfo = res;
        this.loading = false;
      })
      .catch((err) => {
        console.log(err);
        this.$router.push("/");
      });
    }
  },
  async created() {
    await this.me()
  },
};
</script>