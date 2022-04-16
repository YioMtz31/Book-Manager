<template>
    <p>Delete the book: {{ bookTitle }}?</p>
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
    created() {
        eventBus.$on("continueClicked", (data) => {
            this.delete();
        });
    },
    methods: {
        async delete() {
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
