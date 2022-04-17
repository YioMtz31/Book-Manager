<template>
    <div class="table-responsive pe-5">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th
                        v-for="column in columns"
                        :key="column.name"
                        scope="col"
                    >
                        <div
                            class="d-flex align-items-center justify-content-start"
                        >
                            <div>{{ column.label }}</div>
                            <div class="ms-2" v-if="column.sortable">
                                <i
                                    class="fs-6"
                                    :style="'cursor:pointer;'"
                                    :class="{
                                        'bi bi-chevron-down':
                                            sortOrders[column.name] <= 0,
                                        'bi bi-chevron-up':
                                            sortOrders[column.name] === 1,
                                        'bi bi-chevron-expand':
                                            sortOrders[column.name] === 0,
                                    }"
                                    @click="$emit('sort', column.name)"
                                ></i>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <slot />
        </table>
    </div>
</template>

<script>
export default {
    props: {
        columns: {
            type: Array,
            default: function () {
                return new Array();
            },
        },
        sortKey: {
            type: String,
            default: "",
        },
        sortOrders: {
            type: Object,
            default: function () {
                return {};
            },
        },
    },
};
</script>
