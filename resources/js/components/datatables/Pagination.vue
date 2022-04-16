<template>
    <nav aria-label="Table navigation" class="d-flex">
        <span v-if="pagination.total > 0" class="me-5">
            {{ pagination.from }} - {{ pagination.to }} of
            {{ pagination.total }}
        </span>
        <ul
            v-if="pagination.total > 25"
            class="pagination d-flex align-items-center"
        >
            <li class="page-item">
                <button
                    v-if="pagination.prevPageUrl"
                    class="page-link"
                    @click="$emit('prev')"
                >
                    Previous
                </button>
                <button v-else class="opacity-50 disabled" :disabled="true">
                    Previous
                </button>
            </li>
            <li class="page-item">
                <button
                    v-if="pagination.nextPageUrl"
                    class="page-link"
                    @click="$emit('next')"
                >
                    Next
                </button>

                <button v-else class="opacity-50 disabled" :disabled="true">
                    Next
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        pagination: {
            type: Object,
            default: function () {
                return {};
            },
        },
    },
};
</script>

<style scoped>
ul li.page-item button {
    cursor: pointer;
    text-decoration: none;

    @apply py-2 px-4;
    @apply text-blue-700 font-semibold;
    @apply border border-blue-500 rounded bg-transparent;
}
ul li.page-item button:hover {
    @apply bg-blue-500 text-white border-transparent;
}
ul li button.disabled-link,
ul li button.disabled-link:hover {
    @apply py-2 px-4 mx-2;
    @apply bg-gray-300 rounded-l;
    @apply text-gray-700 font-bold;
}
</style>
