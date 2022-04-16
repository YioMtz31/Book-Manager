<template>
    <form>
        <div class="m-2">
            <label for="name">Book name</label>
            <input
                v-model.trim="state.name"
                type="text"
                class="form-control"
                :class="
                    v$.name.$error || state.serverError.errors.name
                        ? 'border border-danger'
                        : ''
                "
                id="name"
                placeholder="Please type Book name"
                v-on:keydown.enter.prevent="submitForm"
            />
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
        <div class="m-2">
            <label for="Author">Book Author</label>
            <Select
                v-model="state.author_id"
                url="api/author"
                v-on:optionSelected="setAuthor"
            />
            <div
                class="input-errors"
                v-for="error of v$.author_id.$errors"
                :key="error.$uid"
            >
                <div class="text-start text-danger">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="m-2">
            <label for="Author">Book Category</label>
            <Select
                v-model="state.category_id"
                url="api/category"
                v-on:optionSelected="setCategory"
            />
            <div
                class="input-errors"
                v-for="error of v$.category_id.$errors"
                :key="error.$uid"
            >
                <div class="text-start text-danger">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div v-if="state.serverError.status" class="text-start text-danger">
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
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" @click="submitForm" class="btn btn-success">
            Save
        </button>
    </form>
</template>

<script>
import useVuelidate from "@vuelidate/core";
import { required, integer } from "@vuelidate/validators";
import { reactive, watch } from "@vue/composition-api";
import Select from "../SelectComponent.vue";

export default {
    components: { Select },
    setup() {
        const state = reactive({
            name: "",
            author_id: "",
            category_id: "",
            publication_date: "",
            user_id: "",
            serverError: {
                status: false,
                errors: [],
            },
        });
        const rules = {
            name: { required },
            author_id: { integer, required },
            category_id: { integer, required },
            publication_date: { required },
            user_id: { integer },
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
    methods: {
        setAuthor(id) {
            this.state.author_id = id;
        },
        setCategory(id) {
            this.state.category_id = id;
        },
        setUser(id) {
            this.state.user_id = id;
        },
        async submitForm() {
            this.v$.$reset();
            const isFormCorrect = await this.v$.$validate();
            if (!isFormCorrect) return;
            axios
                .post("/api/books", {
                    name: this.state.name,
                    author_id: this.state.author_id,
                    category_id: this.state.category_id,
                    publication_date: this.state.publication_date,
                    user_id: this.state.user_id,
                })
                .then((response) => {
                    this.$router.push("/books");
                })
                .catch((error) => {
                    this.state.serverError.status = true;
                    this.state.serverError.errors = error.response.data.errors;
                });
        },
    },
};
</script>
