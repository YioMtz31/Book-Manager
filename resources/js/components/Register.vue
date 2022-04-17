<template>
    <main-component>
        <template v-slot:content>
            <div class="d-flex w-75 p-3">
                <form>
                    <div class="form-floating mb-2">
                        <input
                            v-model.trim="state.name"
                            type="text"
                            class="form-control"
                            :class="
                                v$.name.$error ? 'border border-danger' : ''
                            "
                            id="user-name"
                            placeholder="name@example.com"
                        />
                        <label for="user-name">Name</label>
                        <div
                            class="input-errors"
                            v-for="error of v$.name.$errors"
                            :key="error.$uid"
                        >
                            <div class="text-start text-danger">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-2">
                        <input
                            v-model.trim="state.email"
                            type="email"
                            class="form-control"
                            :class="
                                v$.email.$error ? 'border border-danger' : ''
                            "
                            id="email"
                            placeholder="name@example.com"
                        />
                        <label for="email">Email address</label>
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
                    <div class="form-floating mb-2">
                        <input
                            v-model.trim="state.password"
                            type="password"
                            class="form-control"
                            :class="
                                v$.password.$error ? 'border border-danger' : ''
                            "
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
                    <div class="form-floating mb-2">
                        <input
                            v-model.trim="state.password_confirmation"
                            type="password"
                            class="form-control"
                            :class="
                                v$.password_confirmation.$error
                                    ? 'border border-danger'
                                    : ''
                            "
                            id="floatingPasswordConfirmation"
                            placeholder="Password Confirmation"
                        />
                        <label for="floatingPasswordConfirmation"
                            >Password Confirmation</label
                        >
                        <div
                            class="input-errors"
                            v-for="error of v$.password_confirmation.$errors"
                            :key="error.$uid"
                        >
                            <div class="text-start text-danger">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-2">
                        <div class="form-check">
                            <input
                                v-model.trim="state.checkbox"
                                class="form-check-input"
                                type="checkbox"
                                id="flexCheckChecked"
                            />
                            <label
                                class="form-check-label"
                                for="flexCheckChecked"
                            >
                                Is Admin?
                            </label>
                        </div>
                    </div>

                    <button
                        @click="submitForm"
                        class="w-100 btn btn-lg btn-primary"
                        type="button"
                    >
                        Register
                    </button>
                </form>
            </div>
        </template>
    </main-component>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import { reactive } from "@vue/composition-api";
import MainComponent from "./MainComponent.vue";

export default {
    components: { MainComponent },
    setup() {
        const state = reactive({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            checkbox: false,
        });
        const rules = {
            name: { required },
            email: { required, email },
            password: { required },
            password_confirmation: { required },
        };

        const v$ = useVuelidate(rules, state);

        return { state, v$ };
    },
    mounted() {
        this.$store.commit("setPageTitle", "Register New User");
    },
    methods: {
        async submitForm() {
            this.v$.$reset();
            const isFormCorrect = await this.v$.$validate();
            // you can show some extra alert to the user or just leave the each field to show it's `$errors`.
            if (!isFormCorrect) return;
            axios
                .post("/api/users", {
                    name: this.state.name,
                    email: this.state.email,
                    password: this.state.password,
                    password_confirmation: this.state.password_confirmation,
                    is_admin: this.state.checkbox,
                })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
};
</script>
