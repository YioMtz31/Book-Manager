<template>
    <div>
        <p>Delete the book: {{ bookTitle }}?</p>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" @click="deleteBook" class="btn btn-success">
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
        async deleteBook() {
            return await axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .delete("/api/books/" + this.bookId)
                    .then((response) => {
                        if (response.data) {
                            this.$emit("deleted");
                            eventBus.$emit("triggerCloseModal");
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
