<template>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Sale Store</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <!--<button class="p-2 text-dark" :to="{ name: 'manager' }">Manager</button>-->
            <router-link :to="{ name: 'manager' }">Перейти к Manager</router-link>

            <a class="p-2 text-dark" href="#">Enterprise</a>
            <a class="p-2 text-dark" href="#">Support</a>
            <a class="p-2 text-dark" href="#">Pricing</a>
        </nav>
        <div v-if="this.user === null">
            <a @click="signIn" class="btn btn-outline-primary" href="#">Login</a>
        </div>

        <div v-else>
            <a @click="logout" class="btn btn-outline-primary" href="#">Logout</a>

        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';

    export default {
        name: 'header-v',
        data() {
            return {
                name: null,
                url: null,
                description: null
            }
        },
        computed: {
            ...mapGetters({
                user: 'currentUser'
            }),
        },
        methods: {

            signIn() {
                this.$router.push('login')
            },
            logout() {
                this.$store.commit('logout');
                this.$router.push('login');

            }

        },
        mounted() {
            let auth;
            if (this.user) {
                let isObject = function (a) {
                    return (!!a) && (a.constructor === Object);
                };
                if (isObject(this.user)) {
                    auth = this.user;
                } else {
                    auth = JSON.parse(this.user);
                }

                this.name = auth.name;
            }


        }
    }
</script>
