<template>
    <div class="container">
        <div class="card">
            <div class="card-header">Conduit WhoAMI</div>

            <div class="card-body">
                <template v-if="info == null">
                    Loading...
                </template>
                <template v-else>
                    <img :src="info.data.image" class="img-fluid"/>
                    <h2>{{info.data.userName}}</h2>
                    <button v-on:click="showJson = !showJson">Toggle JSON</button>
                    <pre v-if="showJson">{{info.data}}</pre>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                info: null,
                showJson: false
            }
        },
        mounted() {
            console.log('Component mounted.')
            axios.get('/api/conduit')
            .then(response => (this.info = response)) ////////ddd
        }
    }
</script>
