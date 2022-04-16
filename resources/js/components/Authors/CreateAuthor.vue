<template>
    <main-component>
        <template v-slot:content>
            <div class="d-flex w-75 p-3">
                <form>
                    <div class="form-floating m-2">
                        <input
                            v-model.trim="state.name"
                            type="text"
                            class="form-control"
                            :class="
                                v$.name.$error || state.serverError.status
                                    ? 'border border-danger'
                                    : ''
                            "
                            id="floatingInput"
                            placeholder="Please type Author name"
                            v-on:keydown.enter.prevent="submitForm"
                        />
                        <label for="floatingInput"
                            >Please type Author name</label
                        >
                        <div
                            class="input-errors"
                            v-for="error of v$.name.$errors"
                            :key="error.$uid"
                        >
                            <div class="text-start text-danger">
                                {{ error.$message }}
                            </div>
                        </div>
                        <div
                            v-if="state.serverError.status"
                            class="text-start text-danger"
                        >
                            {{ state.serverError.message }}
                        </div>
                    </div>
                    <button
                        @click="submitForm"
                        class="btn btn-lg btn-primary m-2"
                        type="button"
                    >
                        Save
                    </button>
                </form>
            </div>
        </template>
    </main-component>
</template>

<script>
import MainComponent from "../MainComponent.vue";
import useVuelidate from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { reactive, watch } from "@vue/composition-api";

export default {
    components: {
        MainComponent,
    },
    setup() {
        const state = reactive({
            name: "",
            password: "",
            password_confirmation: "",
            serverError: {
                status: false,
                message: "",
            },
        });
        const rules = {
            name: { required },
        };

        const v$ = useVuelidate(rules, state);
        watch(
            () => state.name,
            (currentValue, oldValue) => {
                if (state.serverError.status) {
                    state.serverError.status = false;
                    state.serverError.message = "";
                }
            }
        );

        return { state, v$ };
    },
    mounted() {
        this.$store.commit("setPageTitle", "Add New Author");
    },
    methods: {
        async submitForm() {
            this.v$.$reset();
            const isFormCorrect = await this.v$.$validate();
            // you can show some extra alert to the user or just leave the each field to show it's `$errors`.
            if (!isFormCorrect) return;
            axios
                .post("/api/author", {
                    name: this.state.name,
                })
                .then((response) => {
                    this.$router.push("/authors");
                })
                .catch((error) => {
                    this.state.serverError.status = true;
                    this.state.serverError.message =
                        error.response.data.message;
                });
        },
    },
};
</script>
