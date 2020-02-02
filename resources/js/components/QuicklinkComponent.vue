<template>
    <div v-if="data != null">
        <span v-html="preamble"></span>
        <div class="card">
            <div class="card-header">Open a Ticket</div>

            <div class="card-body">
                <div class="alert alert-success" role="alert" v-if="response != null">
                    <strong>Success</strong> <br />
                    Response: <pre>{{response.data}}</pre> <br />
                    <button class="btn btn-light" @click.prevent="closeSecret">Close</button>
                </div>
                Title: <input type="text" class="form-control" v-model="title"> <br />
                Text: <textarea v-model="text" class="form-control" cols="5" rows="5"></textarea> <br />
                <button class="btn btn-primary"
                        @click.prevent="submitted">Submit!
                </button>
            </div>
        </div>
    </div>
    <div v-else>
        Loading...
    </div>
</template>

<script>
    export default {
        props: ['id', 'webhook'],
        data() {
            return {
                data: null,
                title: '',
                text: '',
                preamble: '',
                response: null
            }
        },
        mounted() {
            this.load()
        },
        methods: {
            submitted() {
                axios.post(`/webhook/invoke/${this.webhook}`, {
                    title: this.title,
                    text: this.text
                })
                .then(response => (this.response = response))
                .catch(function(response){
                    alert(response)
                })
            },
            load() {
                self = this
                this.data = null
                axios.get(`/api/quicklink/${this.id}`)
                .then(function(response){
                    self.data = response
                    self.title = response.data.title
                    self.text = response.data.text
                    self.preamble = response.data.preamble
                })
            },
            closeSecret() {
                this.response = null;
            }
        }
    }
</script>
