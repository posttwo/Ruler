<template>
    <div class="card">
        <div class="card-header">
            Quicklinks <button class="btn btn-primary"
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
                        <th>Webhook</th>
                        <th>Key</th>
                        <th>Title</th>
                        <th>Text</th>
                        <th>Preamble</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="q in data.data">
                            <tr>
                               <td>{{q.id}}</td>
                               <td>{{q.webhook_id}}</td>
                               <td><pre>{{q.key}}</pre></td>
                               <td>{{q.title}}</td>
                               <td>
                                   <textarea v-model="q.text" class="form-control" cols="5" rows="5"></textarea>
                                </td>
                                <td>
                                   <textarea v-model="q.preamble" class="form-control" cols="5" rows="5"></textarea>
                                </td>
                               <td>
                                   <button class="btn btn-success" @click.prevent="viewQuicklink(q.id, q.key)">View</button>
                                   <button class="btn btn-danger" @click.prevent="deleteQuicklink(q.id)">Delete</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    </table>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: null,
            }
        },
        mounted() {
            this.load()
        },

        methods: {
            load() {
                this.data = null
                axios.get(`/api/quicklink`)
                .then(response => (this.data = response)) ////////ddd
            },
            deleteQuicklink(id){
                axios.delete(`/api/quicklink/${id}`)
                .then(response => ( this.load() ))
                .catch(function(response){
                    alert(response)
                })
            },
            viewQuicklink(id, key){
                window.location.href = `/q/${id}/${key}`;
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
