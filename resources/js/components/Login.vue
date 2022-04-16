<template>
    <div class="form-signin mh-100 h-100 text-center">
        <form>
            <img
                class="img-fluid mb-4"
                src="images/library.jpg"
                alt="Book Manager"
            />
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input
                    v-model.trim="state.email"
                    type="email"
                    class="form-control"
                    :class="v$.email.$error ? 'border border-danger' : ''"
                    id="floatingInput"
                    placeholder="name@example.com"
                />
                <label for="floatingInput">Email address</label>
                <div
                    class="input-errors"
                    v-for="error of v$.email.$errors"
                    :key="error.$uid"
                >
                    <div class="text-start text-danger">
                        {{ error.$message }}
                    </div>
                </div>
            </div>
            <div class="form-floating">
                <input
                    v-model.trim="state.password"
                    type="password"
                    class="form-control"
                    :class="v$.password.$error ? 'border border-danger' : ''"
                    id="floatingPassword"
                    placeholder="Password"
                />
                <label for="floatingPassword">Password</label>
                <div
                    class="input-errors"
                    v-for="error of v$.password.$errors"
                    :key="error.$uid"
                >
                    <div class="text-start text-danger">
                        {{ error.$message }}
                    </div>
                </div>
            </div>

            <button
                @click="submitForm"
                class="w-100 btn btn-lg btn-primary"
                type="button"
            >
                Sign in
            </button>
            <p class="mt-5 mb-3 text-muted">
                &copy; {{ new Date().getFullYear() }}
            </p>
        </form>
    </div>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { reactive } from "@vue/composition-api";

export default {
    setup() {
        const state = reactive({
            email: "",
            password: "",
        });
        const rules = {
            email: { required, email },
            password: { required },
        };

        const v$ = useVuelidate(rules, state);

        return { state, v$ };
    },
    mounted() {
        console.log("login page loaded");
    },
    methods: {
        async submitForm() {
            this.v$.$reset();
            const isFormCorrect = await this.v$.$validate();
            // you can show some extra alert to the user or just leave the each field to show it's `$errors`.
            if (!isFormCorrect) return;
            axios.get("/sanctum/csrf-cookie").then((response) => {
                // Login...
                axios
                    .post("/login", {
                        email: this.state.email,
                        password: this.state.password,
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            this.$store.commit("setIsAuthenticated", true);
                            this.$router.push("/");
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });
        },
    },
};
</script>

<style></style>
