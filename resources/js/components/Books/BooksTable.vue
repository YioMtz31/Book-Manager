<template>
    <main-component>
        <template v-slot:content>
            <portal to="tableActions">
                <div class="">
                    <router-link :to="'/book'"> Add Book </router-link>
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
                        @input="getBooks()"
                    />
                </label>
            </portal>
            <DataTables
                :columns="columns"
                :sort-key="sortKey"
                :sort-orders="sortOrders"
                role="region"
                aria-label="Results"
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
                <p v-else-if="books.length == 0" class="text-danger">
                    No records found!
                </p>
                <tbody v-else>
                    <tr v-for="book in books" :key="book.id">
                        <td>
                            {{ book.id }}
                        </td>
                        <td>
                            {{ book.name }}
                        </td>
                        <td>
                            {{ book.author.name }}
                        </td>
                        <td>
                            {{ book.category.name }}
                        </td>
                        <td>
                            {{ book.publication_date }}
                        </td>
                        <td>
                            {{ book.user ? book.user.name : "" }}
                        </td>
                        <td>actions</td>
                    </tr>
                </tbody>
            </DataTables>
            <Pagination
                :pagination="pagination"
                @prev="getBooks(pagination.prevPageUrl)"
                @next="getBooks(pagination.nextPageUrl)"
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
                name: "bookId",
                label: "Book ID",
            },
            {
                name: "BName",
                label: "Book Name",
            },
            {
                name: "bookAuthor",
                label: "Author",
            },
            {
                name: "bookCategory",
                label: "Category",
            },
            {
                name: "bookPublicationDate",
                label: "Publication Date",
            },
            {
                name: "bookUser",
                label: "Checked out by",
            },
            {
                name: "actions",
                label: "Actions",
            },
        ];
        columns.forEach((column) => {
            sortOrders[column.name] = -1;
        });
        return {
            loading: true,
            books: [],
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
        this.$store.commit("setPageTitle", "Books");
        this.getBooks();
    },
    methods: {
        async getBooks(url = "/api/books") {
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
                        this.books = response.data.data;
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
            this.getBooks();
        },
        getIndex(array, key, value) {
            return array.findIndex((i) => i[key] == value);
        },
    },
};
</script>
