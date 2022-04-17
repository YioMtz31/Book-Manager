<template>
    <div class="">
        <div class="container-fluid">
            <div class="row">
                <Navigation />
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="h2">{{ $store.state.pageTitle }}</h1>
                        <portal-target name="tableActions" />
                        <portal-target name="searchbox" />
                    </div>
                    <slot name="content"></slot>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
import Navigation from "./SideNavBar.vue";
export default {
    name: "mainPage",
    components: { Navigation },
    mounted() {},
};
</script>
