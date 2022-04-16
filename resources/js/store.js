import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

let initialState = () => {
    return {
        isAuthenticated: false,
        pageTitle: "",
    };
};
// Create a new store instance.
const store = new Vuex.Store({
    state() {
        return {
            isAuthenticated: false,
            pageTitle: "",
        };
    },
    mutations: {
        reset(state) {
            // acquire initial state
            const s = initialState();
            Object.keys(s).forEach((key) => {
                state[key] = s[key];
            });
        },
        setIsAuthenticated(state, value) {
            state.isAuthenticated = value;
        },
        setPageTitle(state, value) {
            state.pageTitle = value;
        },
    },
    actions: {
        signout({ commit }) {
            return axios
                .post("/logout")
                .then((response) => {
                    commit("reset", false);
                    return true;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
    plugins: [createPersistedState()],
});

export default store;