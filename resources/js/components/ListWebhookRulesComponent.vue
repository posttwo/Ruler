<template>
    <div class="card">
        <div class="card-header">
            Webhook {{id}} Rules <button class="btn btn-primary"
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
                        <th>Action</th>
                        <th>Config</th>
                        <th>Condition</th>
                        <th>Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="rule in data.data">
                            <tr>
                               <td>{{rule.id}}</td>
                               <td>{{rule.action}}</td>
                               <td><pre>{{rule.config}}</pre></td>
                               <td>{{rule.condition_type}} : {{rule.condition_value}}</td>
                               <td>Edit</td>
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
        props: ['id'],
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
                axios.get(`/api/webhook/${this.id}/rule`)
                .then(response => (this.data = response)) ////////ddd
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
