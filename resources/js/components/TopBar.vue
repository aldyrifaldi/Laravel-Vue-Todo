<template>
    <div>
        <nav class="navbar shadow navbar-expand-sm navbar-dark bg-success">
            <a class="navbar-brand font-weight-bold text-capitalize" href="#">TodoVue</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <div class="mr-auto"></div>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item" v-if="user.authenticated">
                        <router-link class="nav-link" :to="{name:'home'}">Home</router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a v-if="user.authenticated" class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aldy Rifaldi.B</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <router-link class="dropdown-item" :to="{name:'completed-tasks'}">Completed Tasks</router-link>
                            <a  @click.prevent="signOut" class="dropdown-item" href="#">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex"
export default {
    computed: {
        ...mapGetters({
            user: "auth/user"
        }),
    },
    methods: {
        ...mapActions({
            logout: "auth/logout"
        }),
        signOut() {
            this.logout().then(() => {
                this.$router.replace({name:'login'})
            })
        }
    }
}
</script>
