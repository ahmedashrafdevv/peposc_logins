<template>
  <div class="login">
    <h2
      class="text-center"
      @click="
        $router.push({
          name: 'login',
          params: { email: 'esolve.eg@gmail.com/' },
        })
      "
      v-if="failed"
    >
      Sorry ! login failed
    </h2>
    <h2
      class="text-center"
      @click="
        $router.push({
          name: 'login',
          params: { email: 'esolve.eg@gmail.com/' },
        })
      "
      v-if="!loading"
    >
      Please choose login method
    </h2>
    <div class="logging-in" v-else>
      <span>logging you in </span>
      <div class="lds-ellipsis">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>
    <div class="buttons">
      <a @click.prevent="redirect('google')" href="" class="button google">
        <svg
          width="50"
          height="50"
          viewBox="0 0 256 262"
          xmlns="http://www.w3.org/2000/svg"
          preserveAspectRatio="xMidYMid"
        >
          <path
            d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
            fill="#4285F4"
          />
          <path
            d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
            fill="#34A853"
          />
          <path
            d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
            fill="#FBBC05"
          />
          <path
            d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
            fill="#EB4335"
          />
        </svg>
        GOOGLE
      </a>
      <a href="#" @click.prevent="redirect('facebook')" class="button facebook">
        <svg
          version="1.1"
          id="Layer_1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 324.143 324.143"
          style="enable-background: new 0 0 324.143 324.143"
          xml:space="preserve"
        >
          <g>
            <g>
              <g>
                <path
                  d="M162.071,0C73.162,0,0.83,72.332,0.83,161.241c0,37.076,12.788,73.004,36.1,101.677c-6.65,16.756-17.788,31.245-32.401,42.089c-2.237,1.66-3.37,4.424-2.94,7.177c0.429,2.754,2.349,5.042,4.985,5.942c11.683,3.992,23.856,6.017,36.182,6.017c19.572,0,38.698-5.093,55.569-14.763c20.158,8.696,41.584,13.104,63.747,13.104c88.909,0,161.241-72.333,161.241-161.242S250.98,0,162.071,0z M162.071,307.483c-21.32,0-41.881-4.492-61.11-13.351c-2.292-1.057-4.959-0.89-7.102,0.443c-15.313,9.529-32.985,14.566-51.104,14.566c-6.053,0-12.065-0.564-17.981-1.684c12.521-12.12,22.014-26.95,27.788-43.547c0.878-2.525,0.346-5.328-1.398-7.354C28.378,230.07,15.83,196.22,15.83,161.241C15.83,80.604,81.434,15,162.071,15s146.241,65.604,146.241,146.241C308.313,241.88,242.709,307.483,162.071,307.483z"
                />
                <path
                  d="M205.201,113.646h-21.2v-6.94c0-0.568,0.057-0.932,0.106-1.142c0.099-0.017,0.227-0.029,0.378-0.029h20.258c4.143,0,7.5-3.357,7.5-7.5V67.093c0-4.13-3.339-7.483-7.47-7.5l-27.926-0.113c-33.585,0-45.502,24.429-45.502,45.349v8.818h-10.406c-4.143,0-7.5,3.357-7.5,7.5v36.115c0,4.143,3.357,7.5,7.5,7.5h10.556v82.782c0,4.143,3.357,7.5,7.5,7.5h36.112c4.143,0,7.5-3.357,7.5-7.5v-82.782h19.304c3.879,0,7.117-2.957,7.469-6.819l3.29-36.115c0.191-2.099-0.509-4.182-1.93-5.737C209.319,114.533,207.309,113.646,205.201,113.646z M195.063,149.762h-19.956c-4.143,0-7.5,3.357-7.5,7.5v82.782h-21.112v-82.782c0-4.143-3.357-7.5-7.5-7.5h-10.556v-21.115h10.406c4.143,0,7.5-3.357,7.5-7.5v-16.318c0-9.125,2.972-30.349,30.472-30.349l20.426,0.083v15.973h-12.758c-7.458,0-15.484,5.061-15.484,16.171v14.44c0,4.143,3.357,7.5,7.5,7.5h20.486L195.063,149.762z"
                />
              </g>
            </g>
          </g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
          <g></g>
        </svg>
        FACEBOOK
      </a>
      <a
        href="#"
        @click.prevent="redirect('microsoft')"
        class="button microsoft"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 23">
          <path fill="#f3f3f3" d="M0 0h23v23H0z" />
          <path fill="#f35325" d="M1 1h10v10H1z" />
          <path fill="#81bc06" d="M12 1h10v10H12z" />
          <path fill="#05a6f0" d="M1 12h10v10H1z" />
          <path fill="#ffba08" d="M12 12h10v10H12z" />
        </svg>
        MICOSOFT
      </a>
    </div>
  </div>
</template>
<script>
import { redirect } from "../Api";
export default {
  computed: {},
  data() {
    return {
      loading: false,
      failed: false,
    };
  },
  methods: {
    redirect(driver) {
      // EventBus.$emit('loggedIn', true);
      this.loading = true;
      redirect(driver).then((res) => {
        this.loading = true;
        const win = window.open(
          res,
          "hello",
          "toolbar=0,status=0,width=626,height=700"
        );
      });
    },
  },
  created() {
    window.addEventListener("storage", () => {
      this.$router.push({ name: "user" });
    });
  },
};
</script>