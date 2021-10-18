import Vue from 'vue'
import VueRouter from 'vue-router'
import 'vue-progress-path/dist/vue-progress-path.css'
import VueProgress from 'vue-progress-path'
import App from './views/app.vue'
import Auth from './views/auth.vue'
import Admin from './views/admin.vue'
import User from './views/user.vue'
import Login from './views/login.vue'
import Unauthorized from './views/unauthorized.vue'
import NotFound from './views/notfound.vue'
import guest from './middlewares/guest'
import auth from './middlewares/auth'
import Api from './Api';
Api.init()
Vue.use(VueProgress, {
    defaultShape: 'circle',
  })
    Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'auth',
            component: Auth,
            meta: {
                middleware:guest
            }

        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin

        },
        {
            path: '/user',
            name: 'user',
            component: User,
            meta: {
                middleware:auth
            }

        },
        {
            path: '/:email/login',
            name: 'login',
            component: Login

        },
        {
            path: '/unauthorized',
            name: 'unauthorized',
            component: Unauthorized

        },
        {
            path: "*",
            redirect: "/404",
          },
          {
            // the 404 route, when none of the above matches
            path: "/404",
            name: "404",
            component: () =>NotFound,
          },
        

    ],

});


router.beforeEach((to , from , next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware
    return middleware(next)
})
  
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
