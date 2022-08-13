<template>
    <div class="w-25 m-auto align-items-center">
        <div class="card card-body">
            <form action="">
                <div class="form-group">
                    <label for="email">Name</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter your name"
                           v-model="user.name" :class="[{'is-invalid': errorFor('name')}]"/>
                    <v-errors :errors="errorFor('name')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter your e-mail"
                           v-model="user.email" :class="[{'is-invalid': errorFor('email')}]"/>
                    <v-errors :errors="errorFor('email')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Enter your password"
                        v-model="user.password"
                        :class="[{'is-invalid': errorFor('password')}]"/>
                    <v-errors :errors="errorFor('password')"></v-errors>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="Confirm password"
                        v-model="user.password_confirmation"
                        :class="[{'is-invalid': errorFor('password_confirmation')}]"/>
                    <v-errors :errors="errorFor('password')"></v-errors>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading"
                        @click.prevent="register()">
                    Register
                </button>
                <hr/>
                <div class="text-nowrap">
                    Already have an account?
                    <router-link :to="{name: 'login'}" class="font-weight-bold">Sign In</router-link>
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
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },
            loading: null
        }
    },
    methods: {
        register() {
            this.loading = true;
            this.errors = null;
            axios.post('/register', this.user).then((response) => {
                if (response.status === 201) {
                    logIn();
                    this.$store.dispatch('loadUser');
                    this.$router.push({name: 'bookables'});
                }
            }).catch((err) => {
                this.errors = err.response && err.response.data.errors;
            }).then(() => {
                this.loading = false
            });
        }
    }
}
</script>
