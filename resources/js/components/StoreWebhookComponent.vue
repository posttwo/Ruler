<template>
    <div class="card">
        <div class="card-header">Create Webhook</div>

        <div class="card-body">
            <div class="alert alert-success" role="alert" v-if="response != null">
                <strong>Webhook #{{response.data.id}} Created</strong> <br />
                Secret: <pre>{{response.data.secret}}</pre> <br />
                <button class="btn btn-light" @click.prevent="closeSecret">Close</button>
            </div>
            <select v-model="selected">
                <option v-for="option in options" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select> <br />
            <span>Selected: {{ selected }}</span> <br />
            <button class="btn btn-primary"
                    @click.prevent="submitted">Crete Webhook!
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: 'GenericWebhookProcessor',
                response: null,
                options: [
                    {text: "Generic Webhook", value: "GenericWebhookProcessor"}
                ]
            }
        },
        methods: {
            submitted() {
                axios.post('/api/webhook', {
                    type: this.selected
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
