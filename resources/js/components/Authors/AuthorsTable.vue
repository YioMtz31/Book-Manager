<template>
    <main-component>
        <template v-slot:content>
            <portal to="tableActions">
                <div class="">
                    <router-link class="author-link" :to="'/author'">
                        Add Author
                    </router-link>
                </div>
            </portal>
            <portal to="searchbox">
                <label class="form-label">
                    <span class="visually-hidden">
                        <span>Search</span>
                    </span>
                    <input
                        v-model="tableData.search"
                        class="form-control w-100 d-block"
                        type="text"
                        placeholder="Search"
                        @input="getAuthors(searchUrl)"
                    />
                </label>
            </portal>
            <DataTables
                :columns="columns"
                :sort-key="sortKey"
                :sort-orders="sortOrders"
                role="region"
                aria-label="Accepted Results"
                @sort="sortBy"
            >
                <tr v-if="loading">
                    <td>
                        <div class="w-100">Loading Please Wait...</div>
                    </td>
                    <td>
                        <div class="w-100"></div>
                    </td>
                </tr>
                <p v-else-if="authors.length == 0" class="text-danger">
                    No records found!
                </p>
                <tbody v-else>
                    <tr
                        v-for="(author, index) in authors"
                        :key="author.id + 'i' + index"
                    >
                        <td>
                            {{ author.id }}
                        </td>
                        <td>
                            {{ author.name }}
                        </td>
                    </tr>
                </tbody>
            </DataTables>
            <Pagination
                :pagination="pagination"
                @prev="getAuthors(pagination.prevPageUrl)"
                @next="getAuthors(pagination.nextPageUrl)"
            />
        </template>
    </main-component>
</template>

<script>
import MainComponent from "../MainComponent.vue";
import DataTables from "../datatables/DataTables.vue";
import Pagination from "../datatables/Pagination.vue";
export default {
    components: {
        DataTables,
        Pagination,
        MainComponent,
    },
    data() {
        let sortOrders = {};
        let columns = [
            {
                name: "AuthorId",
                label: "Author ID",
            },
            {
                name: "AuthorName",
                label: "Author Name",
            },
        ];
        columns.forEach((column) => {
            sortOrders[column.name] = -1;
        });
        return {
            searchUrl: "api/authors",
            loading: true,
            authors: [],
            columns: columns,
            sortKey: "col1",
            sortOrders: sortOrders,
            perPage: ["10", "20", "30"],
            tableData: {
                draw: 0,
                length: 15,
                search: "",
                column: 0,
                dir: "asc",
            },
            pagination: {
                lastPage: "",
                currentPage: "",
                total: "",
                lastPageUrl: "",
                nextPageUrl: "",
                prevPageUrl: "",
                from: "",
                to: "",
            },
        };
    },
    created() {
        this.$store.commit("setPageTitle", "Authors");
        this.getAuthors();
    },
    methods: {
        async getAuthors(url = "/api/author") {
            this.tableData.draw++;
            return await axios
                .get(url, {
                    params: this.tableData,
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                .then((response) => {
                    if (
                        parseInt(this.tableData.draw) ===
                        parseInt(response.data.draw)
                    ) {
                        this.authors = response.data.data;
                        this.configPagination(response);
                        this.loading = false;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        configPagination(response) {
            let data = response.data;
            this.pagination.lastPage = data.meta.last_page;
            this.pagination.currentPage = data.meta.current_page;
            this.pagination.total = data.meta.total;
            this.pagination.lastPageUrl = data.links.last;
            this.pagination.nextPageUrl = data.links.next;
            this.pagination.prevPageUrl = data.links.prev;
            this.pagination.from = data.meta.from;
            this.pagination.to = data.meta.to;
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, "name", key);
            this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
            this.getAuthors();
        },
        getIndex(array, key, value) {
            return array.findIndex((i) => i[key] == value);
        },
    },
};
</script>
