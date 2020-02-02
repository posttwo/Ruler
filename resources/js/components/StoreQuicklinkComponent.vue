<template>
    <div class="card">
        <div class="card-header">Quicklink Creation</div>

        <div class="card-body">
            <div class="alert alert-success" role="alert" v-if="response != null">
                <strong>Quacklink Daily</strong> <br />
                Config: <pre>{{response.data}}</pre> <br />
                <button class="btn btn-light" @click.prevent="closeSecret">Close</button>
            </div>
            WebookID: <input type="text" class="form-control" v-model="webhookId"> <br />
            Key: <input type="text" class="form-control" v-model="key"> <br />
            Title: <input type="text" class="form-control" v-model="title"> <br />
            Text: <textarea v-model="text" class="form-control" cols="5" rows="5"></textarea> <br />
            Preamble: <textarea v-model="preamble" class="form-control" cols="5" rows="5"></textarea> <br />
            <button class="btn btn-primary"
                    @click.prevent="submitted">Quacklank Hourly!
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                webhookId: '',
                key: '',
                title: '',
                text: '',
                preamble: '',
                response: null
            }
        },
        methods: {
            submitted() {
                axios.post(`/api/quicklink`, {
                    webhook_id: this.webhookId,
                    key: this.key,
                    title: this.title,
                    text: this.text,
                    preamble: this.preamble
                })
                .then(response => (this.response = response))
                .catch(function(response){
                    alert(response)
                })
            },
            closeSecret() {
                this.response = null;
            }
        }
    }
</script>
