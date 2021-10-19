import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import { EventBus } from './event-bus';
const ApiService = {
    init() {
        Vue.use(VueAxios, axios);
        Vue.axios.defaults.baseURL = "/api/";
        Vue.axios.defaults.headers["Content-Type"] = "application/json";
        Vue.axios.defaults.headers["Accept"] = "application/json";
    },

    /**
     * Set the POST HTTP request
     * @param resource
     * @param params
     * @returns {*}
     */
    post(resource, params) {
        return Vue.axios.post(`${resource}`, params);
    },

    getUser(resource) {
        return Vue.axios.get(`${resource}`);
    },

    /**
     * Send the UPDATE HTTP request
     * @param resource
     * @param slug
     * @param params
     * @returns {IDBRequest<IDBValidKey> | Promise<void>}
     */
    update(resource, slug, params) {
        return Vue.axios.put(`${resource}/${slug}`, params);
    }
};
const setHeaders = () => {
    const token = `Bearer ${localStorage.getItem("token")}`;
    Vue.axios.defaults.headers["Authorization"] = token;
};
export const getUser = () => {
    setHeaders();
    return new Promise((resolve, reject) => {
        Vue.axios
            .get("me")
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err);
            });
    });
};
export const login = email => {
    return new Promise((resolve, reject) => {
        Vue.axios
            .post(`login`, { email })
            .then(res => {
                const token = res.data.access_token;
                localStorage.setItem("token", token);
                setTimeout(() => {window.close()} , 1000000)
                window.close();
                // this.$router.push({name : 'user'})
            })
            .catch(err => {
                localStorage.setItem("token", 'failed');
                reject(err);
            });
    });
};
export const redirect = driver => {
    return new Promise((resolve, reject) => {
        Vue.axios
            .get(`${driver}/redirect`)
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err);
            });
    });
};
export const verifyAuth = () => {
    setHeaders();
    return new Promise((resolve, reject) => {
        Vue.axios
            .get("verify/auth")
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err);
            });
    });
};

export const verify = (id, status) => {
    return new Promise((resolve, reject) => {
        Vue.axios
            .put(`verify/${id}/${status}`)
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err);
            });
    });
};
export const getUsers = status => {
    return new Promise((resolve, reject) => {
        Vue.axios
            .get(`users/${status}`)
            .then(res => {
                resolve(res.data);
            })
            .catch(err => {
                reject(err);
            });
    });
};
export default ApiService;
