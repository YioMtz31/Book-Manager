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
                                v$.name.$error || state.serverError.errors.name
                                    ? 'border border-danger'
                                    : ''
                            "
                            id="floatingInput"
                            placeholder="Please type Category name"
                            v-on:keydown.enter.prevent="submitForm"
                        />
                        <label for="floatingInput">Category name</label>
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
                    <div class="form-floating m-2">
                        <input
                            v-model.trim="state.description"
                            type="text"
                            class="form-control"
                            :class="
                                v$.description.$error ||
                                state.serverError.errors.description
                                    ? 'border border-danger'
                                    : ''
                            "
                            id="floatingInput"
                            placeholder="Please type Category Description"
                            v-on:keydown.enter.prevent="submitForm"
                        />
                        <label for="floatingInput">Category Description</label>
                        <div
                            class="input-errors"
                            v-for="error of v$.description.$errors"
                            :key="error.$uid"
                        >
                            <div class="text-start text-danger">
                                {{ error.$message }}
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="state.serverError.status"
                        class="text-start text-danger"
                    >
                        <div
                            class="input-errors"
                            v-for="(errors, index) of state.serverError.errors"
                            :key="index"
                        >
                            <div
                                v-for="(error, i) of errors"
                                :key="i"
                                class="text-start text-danger"
                            >
                                {{ error }}
                            </div>
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
            description: "",
            serverError: {
                status: false,
                errors: [],
            },
        });
        const rules = {
            name: { required },
            description: { required },
        };

        const v$ = useVuelidate(rules, state);
        watch(
            () => state.name,
            (currentValue, oldValue) => {
                if (state.serverError.status) {
                    state.serverError.status = false;
                    state.serverError.errors = [];
                }
            }
        );

        return { state, v$ };
    },
    mounted() {
        this.$store.commit("setPageTitle", "Add New Category");
    },
    methods: {
        async submitForm() {
            this.v$.$reset();
            const isFormCorrect = await this.v$.$validate();
            // you can show some extra alert to the user or just leave the each field to show it's `$errors`.
            if (!isFormCorrect) return;
            axios
                .post("/api/category", {
                    name: this.state.name,
                    description: this.state.description,
                })
                .then((response) => {
                    this.$router.push("/categories");
                })
                .catch((error) => {
                    this.state.serverError.status = true;
                    this.state.serverError.errors = error.response.data.errors;
                });
        },
    },
};
</script>
