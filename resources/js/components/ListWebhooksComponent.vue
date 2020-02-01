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
                                        <td>
                                            <a href="#" @click.prevent="getinvocations(webhook.id)">Invocations</a><br />
                                            <a :href="`/webhook/${webhook.id}/rule`">Rules</a>
                                        </td>
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
                            <template v-for="(invocation, index) in invocations.data">
                                <tr>
                                    <th scope="row">{{invocation.id}}</th>
                                    <td>{{invocation.status}}</td>
                                    <td>
                                        <button type="button" class="btn btn-secondary" @click.prevent="showDetails(index)">Details</button>
                                    </td>
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

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{modalTitle}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="showModal = false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <pre>{{modalText}}.</pre>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                data: null,
                invocations: null,
                showModal: false,
                modalTitle: '',
                modalText: ''
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
            },
            showDetails(index) {
                this.modalTitle = this.invocations.data[index].id + " Invocation"
                this.modalText = this.invocations.data[index].head
                this.showModal = true
            }
        }
    }
</script>
<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>
