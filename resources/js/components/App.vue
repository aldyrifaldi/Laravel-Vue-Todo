<template>
    <div>
        <!-- required for render page from routes -->
        <router-view></router-view>
    </div>
</template>

<script>
import {setupInterceptor} from '../helpers';

export default {
    created: function() {
        setupInterceptor(() => {
            this.$store.commit("auth/setAuthenticated",false)
            localStorage.removeItem("access_token");
            this.$router.replace("/login");
        });
    }
};
</script>
