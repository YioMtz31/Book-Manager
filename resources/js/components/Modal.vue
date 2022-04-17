<template>
    <!-- Modal -->
    <div
        class="modal fade"
        id="staticBackdrop"
        ref="exampleModal"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ modalTitle }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from "bootstrap";
import { eventBus } from "../app";
export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: "",
        },
    },
    watch: {
        showModal: {
            handler: function (newVal) {
                if (newVal) {
                    this.modal.show();
                }
            },
        },
    },
    computed: {
        modalTitle() {
            return this.title;
        },
    },
    emits: ["closeModal", "continueClicked"],

    data: () => ({
        modal: null,
    }),
    mounted() {
        this.modal = new Modal(this.$refs.exampleModal);
        const myModalEl = document.getElementById("staticBackdrop");
        myModalEl.addEventListener("hidden.bs.modal", (event) => {
            this.$emit("closeModal");
        });
        eventBus.$on("triggerCloseModal", (data) => {
            this.modal.hide();
        });
    },
};
</script>

<style></style>
