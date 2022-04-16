/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;
import VueRouter from "vue-router";
import routes from "./routes";
import VueCompositionAPI from "@vue/composition-api";
import store from "./store";
import PortalVue from "portal-vue";

Vue.use(VueCompositionAPI);
Vue.use(VueRouter);
Vue.use(PortalVue);

const router = new VueRouter({
    mode: "history",
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.name !== "login" && !store.state.isAuthenticated) {
        next({ path: "login" });
    } else if (to.name === "login" && store.state.isAuthenticated) {
        next({ path: "dashboard" });
    } else {
        next();
    }
});

axios.default.withCredentials = true;
axios.interceptors.response.use(undefined, function axiosRetryInterceptor(err) {
    if (
        err.response.status === 401 ||
        err.response.data.message === "Unauthenticated"
    ) {
        store.dispatch("signout");
        router.push("/login");
    }
    return Promise.reject(err);
});

const app = new Vue({
    el: "#app",
    store,
    router,
});
