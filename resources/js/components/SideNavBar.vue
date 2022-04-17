<template>
    <nav
        id="sidebarMenu"
        class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse"
    >
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link
                        class="nav-link"
                        :class="$route.path === '/books' ? 'active' : ''"
                        aria-current="page"
                        :to="'/'"
                    >
                        <i class="bi bi-book"></i>
                        Books
                    </router-link>
                </li>
                <li v-if="$store.state.isAdmin" class="nav-item">
                    <router-link
                        class="nav-link"
                        :class="$route.path === '/authors' ? 'active' : ''"
                        aria-current="page"
                        :to="'/authors'"
                    >
                        <i class="bi bi-person-circle"></i>
                        Authors
                    </router-link>
                </li>
                <li v-if="$store.state.isAdmin" class="nav-item">
                    <router-link
                        class="nav-link"
                        :class="$route.path === '/categories' ? 'active' : ''"
                        aria-current="page"
                        :to="'/Categories'"
                    >
                        <i class="bi bi-tags"></i>
                        Categories
                    </router-link>
                </li>
                <li v-if="$store.state.isAdmin" class="nav-item">
                    <router-link
                        class="nav-link"
                        :class="$route.path === '/register' ? 'active' : ''"
                        aria-current="page"
                        :to="'/register'"
                    >
                        <i class="bi bi-tags"></i>
                        Register User
                    </router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click.prevent="signOut">
                        <i class="bi bi-box-arrow-right"></i>
                        Sign Out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import store from "../store";
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
