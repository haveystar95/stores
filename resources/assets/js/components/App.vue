<template>
    <div class="main">

        <header-v></header-v>

        <router-view></router-view>

    </div>
</template>

<script>
    import HeaderV from './HeaderV.vue';

    export default {
        name: 'app',
        components: {HeaderV}
    }
</script>
