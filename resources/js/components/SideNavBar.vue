<template>
    <nav
        id="sidebarMenu"
        class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse"
    >
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link
                        class="nav-link active"
                        aria-current="page"
                        :to="'/'"
                    >
                        <span data-feather="home"></span>
                        Dashboard
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link
                        class="nav-link active"
                        aria-current="page"
                        :to="'/authors'"
                    >
                        <span data-feather="home"></span>
                        Authors
                    </router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span data-feather="shopping-cart"></span>
                        Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="signOut">
                        <span data-feather="users"></span>
                        Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    methods: {
        async signOut() {
            if (await this.$store.dispatch("signout")) {
                this.$router.push("/login");
            }
        },
    },
};
</script>

<style></style>
