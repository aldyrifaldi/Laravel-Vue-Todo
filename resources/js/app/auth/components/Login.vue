<template>
    <div class="d-flex full-height justify-content-center">
        <div class="card align-self-center">
            <div class="card-body">
                <div v-if="errors.roots" class="alert alert-danger" role="alert">
                  <h4 class="alert-heading">Sign in Failed!</h4>
                  <p>{{errors.roots}}</p>
                </div>
                <h3 class="text-center">Sign In</h3>
                <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" :class="{'is-invalid':errors.email}" name="email" class="form-control" v-model="email" placeholder="Email Address">
                    <small class="text-danger" v-if="errors.email">{{errors.email.join(',')}}</small>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input :class="{'is-invalid': errors.password}" type="password" name="password" class="form-control" v-model="password" placeholder="Your Password">
                    <small class="text-danger" v-if="errors.password">{{errors.password.join(',')}}</small>
                </div>
                <button class="btn btn-primary btn-block text-center" type="submit">Sign In</button>
                Does'nt have an account? <router-link :to="{name:'register'}" class="" >Sign Up</router-link>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions} from "vuex";
export default {
    data() {
        return {
            email: null,
            password: null,
            errors: []
        }
    },
    methods: {
        ...mapActions({
            login: "auth/login"
        }),
        submit() {
            this.login({
                payload: {
                    email: this.email,
                    password: this.password,
                },
                context: this
            })
            .then((res) => {
                this.$router.replace({name:"home"})
            })
            // .catch((err) => {
            //     console.log('error');
            // })
        },
    }
}
</script>
