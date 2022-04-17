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
                :selected="state.author_id"
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
            <label for="Category">Book Category</label>
            <Select
                v-model="state.category_id"
                url="api/category"
                :selected="state.category_id"
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
        <div class="m-2">
            <label for="publication-date">Publication Date</label>
            <input
                v-model.trim="state.publication_date"
                type="text"
                class="form-control"
                :class="
                    v$.publication_date.$error ||
                    state.serverError.errors.publication_date
                        ? 'border border-danger'
                        : ''
                "
                id="publication-date"
                placeholder="yyyy-mm-dd"
                v-on:keydown.enter.prevent="submitForm"
            />
            <div
                class="input-errors"
                v-for="error of v$.publication_date.$errors"
                :key="error.$uid"
            >
                <div class="text-start text-danger">
                    {{ error.$message }}
                </div>
            </div>
        </div>
        <div class="m-2">
            <label for="borrowed-book">Borrowed Book By</label>
            <Select
                v-model="state.user_id"
                url="api/users"
                :selected="state.user_id"
                v-on:optionSelected="setUser"
            />
            <div
                class="input-errors"
                v-for="error of v$.user_id.$errors"
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
import { eventBus } from "../../app";

export default {
    components: { Select },
    props: {
        modalData: {
            type: Object,
            default: function () {
                return {};
            },
        },
    },
    setup(props) {
        const state = reactive({
            name: props.modalData.book ? props.modalData.book.name : "",
            author_id: props.modalData.book
                ? props.modalData.book.author_id
                : "",
            category_id: props.modalData.book
                ? props.modalData.book.category_id
                : "",
            publication_date: props.modalData.book
                ? props.modalData.book.publication_date
                : "",
            user_id: props.modalData.book ? props.modalData.book.user_id : "",
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
        return { state, v$ };
    },
    mounted() {},
    methods: {
        submitForm() {
            if (!this.isEmpty(this.modalData.book)) {
                this.updateBook(this.modalData.book.id);
            } else {
                this.submitBook();
            }
        },
        isEmpty(obj) {
            if (!obj) {
                return true;
            }
            if (
                obj.constructor === Object &&
                Object.entries(obj).length === 0
            ) {
                return true;
            }
            return false;
        },
        setAuthor(id) {
            this.state.author_id = id;
        },
        setCategory(id) {
            this.state.category_id = id;
        },
        setUser(id) {
            this.state.user_id = id;
        },
        async submitBook() {
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
                    eventBus.$emit("triggerCloseModal");
                })
                .catch((error) => {
                    console.log(error);
                    this.state.serverError.status = true;
                    this.state.serverError.errors = error.response.data.errors;
                });
        },
        async updateBook(id) {
            console.log(id);
            if (!id) {
                return false;
            }
            this.v$.$reset();
            const isFormCorrect = await this.v$.$validate();
            if (!isFormCorrect) return;
            axios
                .put(`/api/books/${id}`, {
                    name: this.state.name,
                    author_id: this.state.author_id,
                    category_id: this.state.category_id,
                    publication_date: this.state.publication_date,
                    user_id: this.state.user_id,
                })
                .then((response) => {
                    this.$emit("updated");
                    eventBus.$emit("triggerCloseModal");
                })
                .catch((error) => {
                    console.log(error);
                    this.state.serverError.status = true;
                    this.state.serverError.errors = error.response.data.errors;
                });
        },
    },
};
</script>
