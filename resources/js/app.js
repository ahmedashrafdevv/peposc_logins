import Vue from 'vue'
import VueRouter from 'vue-router'
import 'vue-progress-path/dist/vue-progress-path.css'
import VueProgress from 'vue-progress-path'
import App from './views/app.vue'
import router from './Router'
import Api from './Api';
Api.init()
Vue.use(VueProgress, {
    defaultShape: 'circle',
  })
    Vue.use(VueRouter)

  
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
