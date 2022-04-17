<template>
    <div>
        <p>Do you wish to borrow the book: {{ bookTitle }}?</p>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            No
        </button>
        <button type="button" @click="checkoutBook" class="btn btn-success">
            Yes
        </button>
    </div>
</template>

<script>
import { eventBus } from "../../app";
export default {
    props: {
        modalData: {
            type: Object,
            default() {
                return {};
            },
        },
    },
    computed: {
        bookTitle() {
            return this.modalData.book?.name;
        },
        bookId() {
            return this.modalData.book?.id;
        },
    },
    created() {},
    methods: {
        async checkoutBook() {
            return await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .put(`/api/books/${this.bookId}`, {
                        name: this.modalData.book.name,
                        author_id: this.modalData.book.author_id,
                        category_id: this.modalData.book.category_id,
                        publication_date: this.modalData.book.publication_date,
                        user_id: this.$store.state.user_id,
                    })
                    .then((response) => {
                        this.$emit("updated");
                        eventBus.$emit("triggerCloseModal");
                    })
                    .catch((error) => {
                        console.log(error);
                        this.state.serverError.status = true;
                        this.state.serverError.errors =
                            error.response.data.errors;
                    });
            });
        },
    },
};
</script>
