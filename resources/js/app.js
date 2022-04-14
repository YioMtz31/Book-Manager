/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;
import VueRouter from "vue-router";
import routes from "./routes";

const isAuthenticated = false;
Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.name !== "login" && !isAuthenticated) next({ path: "login" });
    else next();
});

const app = new Vue({
    el: "#app",
    //  store,
    router,
});
