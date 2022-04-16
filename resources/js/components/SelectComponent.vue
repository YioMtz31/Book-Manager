<template>
    <v-select
        v-model="selectedOption"
        :reduce="(option) => option.id"
        label="name"
        :filterable="false"
        :options="options"
        @search="onSearch"
    >
        <template slot="no-options"> type to search book authors.. </template>
        <template slot="option" slot-scope="option">
            <div class="d-center">
                {{ option.name }}
            </div>
        </template>
    </v-select>
</template>

<script>
export default {
    props: {
        url: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            options: [],
            selectedOption: "",
        };
    },
    watch: {
        selectedOption: {
            handler: function (newVal) {
                this.$emit("optionSelected", this.selectedOption);
            },
        },
    },
    methods: {
        onSearch(search, loading) {
            if (search.length) {
                loading(true);
                this.search(loading, search);
            }
        },
        search(loading, search) {
            axios
                .get(`${this.url}/list?search=${escape(search)}`)
                .then((response) => {
                    this.options = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    loading(false);
                });
        },
    },
};
</script>

<style></style>
