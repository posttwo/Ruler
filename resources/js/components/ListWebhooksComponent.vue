<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    List Webhook <button class="btn btn-primary"
                            @click.prevent="load">Refresh!
                    </button>
                </div>

                <div class="card-body">
                    <template v-if="data == null">
                        Loading..
                    </template>
                    <template v-else>
                        <div class="table-responsive">
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Secret</th>
                                <th scope="col">Type</th>
                                <th scope="col">Creation</th>
                                <th scope="col">Tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="webhook in data.data">
                                    <tr>
                                        <th scope="row">{{webhook.id}}</th>
                                        <td>{{webhook.secret}}</td>
                                        <td>{{webhook.type}}</td>
                                        <td>{{webhook.created_at}}</td>
                                        <td><a href="#" @click.prevent="getinvocations(webhook.id)">Invocations</a></td>
                                    </tr>
                                </template>
                            </tbody>
                            </table>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Invocations</div>

                <div class="card-body">
                    <template v-if="invocations == null">
                        Pick an invocation...
                    </template>
                    <template v-else>
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Head</th>
                            <th scope="col">Body</th>
                            <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="invocation in invocations.data">
                                <tr>
                                    <th scope="row">{{invocation.id}}</th>
                                    <td>{{invocation.status}}</td>
                                    <td><pre style="max-width: 100px; max-height: 30px;">{{invocation.head}}</pre></td>
                                    <td><pre>{{invocation.body}}</pre></td>
                                    <td>{{invocation.created_at}}</td>
                                </tr>
                            </template>
                        </tbody>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: null,
                invocations: null
            }
        },
        mounted() {
            this.load()
        },

        methods: {
            load() {
                this.data = null
                axios.get('/api/webhook')
                .then(response => (this.data = response)) ////////ddd
            },
            getinvocations(id) {
                axios.get(`/api/webhook/${id}/invocation`)
                .then(response => (this.invocations = response))
            }
        }
    }
</script>
