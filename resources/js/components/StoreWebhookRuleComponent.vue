<template>
    <div class="card">
        <div class="card-header">Create Rule</div>

        <div class="card-body">
            <div class="alert alert-success" role="alert" v-if="response != null">
                <strong>Rule #{{response.data.id}} Created</strong> <br />
                Config: <pre>{{response.data.config}}</pre> <br />
                <button class="btn btn-light" @click.prevent="closeSecret">Close</button>
            </div>
            Type: <select v-model="selected">
                <option v-for="option in options" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select> <br />
            Config: <textarea v-model="config" class="form-control" cols="5" rows="5"></textarea> <br />
            ConditionType: <input type="text" class="form-control" v-model="conditionType"> <br />
            ConditionValue:  <input type="text" class="form-control" v-model="conditionValue"><br />
            <button class="btn btn-primary"
                    @click.prevent="submitted">Add Rule!
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                selected: '',
                config: 'test',
                conditionType: '',
                conditionValue: '',
                response: null,
                options: [
                    {text: "Set Generic Ticket Field", value: "Tickets\\GenericTicketFieldAction"}
                ]
            }
        },
        methods: {
            submitted() {
                axios.post(`/api/webhook/${this.id}/rule`, {
                    type: this.selected,
                    config: this.config,
                    conditionType: this.conditionType,
                    conditionValue: this.conditionValue
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
