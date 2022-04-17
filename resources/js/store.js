import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

let initialState = () => {
    return {
        isAuthenticated: false,
        isAdmin: false,
        user_id: "",
        pageTitle: "",
        category: {},
        author: {},
    };
};
// Create a new store instance.
const store = new Vuex.Store({
    state() {
        return {
            isAuthenticated: false,
            isAdmin: false,
            user_id: "",
            pageTitle: "",
            category: {},
            author: {},
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
        setIsAdmin(state, value) {
            state.isAdmin = value;
        },
        setUserId(state, value) {
            state.user_id = value;
        },
        setPageTitle(state, value) {
            state.pageTitle = value;
        },
        setCategoryToEdit(state, value) {
            state.category = value;
        },
        clearCategoryToEdit(state) {
            state.category = {};
        },
        setAuthorToEdit(state, value) {
            state.author = value;
        },
        clearAuthorToEdit(state) {
            state.author = {};
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
