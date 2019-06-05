<template>
    <div class="container">
        <h1>Hallo user . . . welcome to your work space.</h1>

    </div>
</template>

<script>
    export default {
        computed:{
            currentUser(){
                return this.$store.getters.currentUser
            }
        }
    }
</script>
