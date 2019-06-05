<template>


    <div class="container">

            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Add Store
            </button>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <div class="mb-3">
                    <label for="name">Name<span class="text-muted"></span></label>
                    <input type="text" id="name" v-model="name" class="form-control" placeholder="Name">
                </div>

                <div class="mb-3">
                    <label for="url">url<span class="text-muted"></span></label>
                    <input type="text" id="url" v-model="url" class="form-control" placeholder="url">
                </div>
                <div class="mb-3">
                    <label for="description">description<span class="text-muted"></span></label>
                    <input type="text" id="description" v-model="description" class="form-control" placeholder="description">
                </div>


                <button @click="parseStore" class="btn btn-info">Save</button>
            </div>

        </div>















        <div class="card-deck mb-3 text-center">


            <div v-for="store in storesList" class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{store.name}}</h4>
                </div>
                <div class="card-body">
                    <!--<h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>-->
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{store.url}}</li>
                        <li>{{store.description}}</li>
                        <li>{{store.created_at}}</li>
                        <!--<li>2 GB of storage</li>-->
                        <!--<li>Email support</li>-->
                        <!--<li>Help center access</li>-->
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-outline-primary">Enter</button>
                </div>
            </div>


        </div>





    </div>


</template>

<script>
    export default {
        name: "Manager",

        data() {
            return {
                name: null,
                url: null,
                description: null,
                storesList: {}
            }
        },
        methods: {
            parseStore() {
                this.$api('createStore', {}, {'name': this.name, 'url': this.url, 'description': this.description})
                    .then(res => {
                        this.getStores();
                    })
                    .catch(error => {
                        this.$store.commit("loginFailed", {error});
                    })
            },
            getStores() {
                this.$api('getStores', {}, {})
                    .then(res => {
                        this.storesList = res;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        mounted() {
            this.getStores();
        }

    }
</script>

<style scoped>

    body {
        background-color: #F8F9FA;
    }
</style>
