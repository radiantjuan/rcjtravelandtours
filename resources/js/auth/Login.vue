<template>
    <div class="w-25 m-auto align-items-center">
        <div class="card card-body">
            <form action="">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter your e-mail"
                           v-model="email" :class="[{'is-invalid': errorFor('email')}]"/>
                    <v-errors :errors="errorFor('email')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="email">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Enter your password"
                        v-model="password"/>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading"
                        @click.prevent="login()">
                    Login
                </button>
                <hr/>
                <div class="text-nowrap">
                    No account yet?
                    <router-link :to="{name: 'bookables'}" class="font-weight-bold">Register</router-link>
                </div>
                <div class="text-nowrap">
                    Forgotten password?
                    <router-link :to="{name: 'bookables'}" class="font-weight-bold">Reset Password</router-link>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import validationErrors from "../shared/mixins/validationErrors";
import {logIn} from "../shared/utils/auth";

export default {
    mixins: [validationErrors],
    data() {
        return {
            email: null,
            password: null,
            loading: null
        }
    },
    methods: {
        login() {
            this.loading = true;
            this.errors = null;
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/login', {
                    email: this.email,
                    password: this.password
                }).then(() => {
                    logIn();
                    this.$store.dispatch('loadUser');
                    this.$router.push({name: 'bookables'});
                }).catch((err) => {
                    this.errors = err.response && err.response.data.errors;
                }).then(() => {
                    this.loading = false
                });
            });
        }
    }
}
</script>
