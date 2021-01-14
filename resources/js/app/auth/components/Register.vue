<template>
    <div class="d-flex full-height justify-content-center">
        <div class="card align-self-center">
            <div class="card-body">
                <div v-if="errors.roots" class="alert alert-danger" role="alert">
                  <h4 class="alert-heading">Sign up Failed!</h4>
                  <p>{{errors.roots}}</p>
                </div>
                <h3 class="text-center">Sign Up</h3>
                <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" :class="{'is-invalid':errors.username}" name="email" class="form-control" v-model="username" placeholder="Email Address">
                    <small class="text-danger" v-if="errors.username">{{errors.username.join(',')}}</small>
                </div>
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
                <div class="form-group">
                    <label for="">Password Confirmation</label>
                    <input :class="{'is-invalid': errors.password}" type="password" name="password_confirmation" class="form-control" v-model="password_confirmation" placeholder="Your Password">
                </div>
                <button class="btn btn-primary btn-block text-center" type="submit">Sign Up</button>
                Already have an account? <router-link :to="{name:'login'}" class="" >Sign In</router-link>
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
            username: null,
            email: null,
            password: null,
            password_confirmation: null,
            errors: []
        }
    },
    methods: {
        ...mapActions({
            register: "auth/register"
        }),
        submit() {
            this.register({
                payload: {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                },
                context: this
            })
            .then((res) => {
                this.$router.replace({name:"home"})
            })
            .catch((err) => {
            })
        },
    }
}
</script>
