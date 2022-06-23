<template>
    <v-dialog
      v-model="dialog"
        persistent
        width="30%"
    >
    <v-form
            ref="form"
            lazy-validation
            v-model="valid"
            class="padding"
        >
      <v-card>
        <div class="card-text">
            <span class="card-text-item"> Create New User </span>
        </div>
            <div class="card-text-input">
                    <v-flex xs10>
                        <v-text-field
                            v-model = "payload.lastname"
                            label="Last Name"
                            required
                            :counter="20"
                            :rules="lastnameRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                        <v-text-field
                            v-model = "payload.firstname"
                            label="First Name"
                            required
                            :counter="20"
                            :rules="firstnameRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                        <v-text-field
                            v-model = "payload.email"
                            label="Email"
                            required
                            :counter="20"
                            :rules="emailRules"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs10>
                        <v-text-field
                            v-model = "payload.phone"
                            label="Phone Number (Ex. 92564563)"
                            required
                            :counter="8"
                            :rules="phoneRules"
                            type="number"
                        ></v-text-field>
                    </v-flex>
                     <v-flex xs10>
                        <v-select dense v-model="types" :items="user_type" item-text="type"  item-value="number"
                            persistent-hint return-object prepend-icon="mdi-map" label="User Type">
                        </v-select>    
                    </v-flex>
                </div>
        
        <v-card-actions>
            <v-spacer></v-spacer>
            <div class="card-text-button">
                <v-btn
                    color="primary"
                    class="mb-2"
                    dark   
                    @click.prevent ="savenew()"  
                    :disabled="!valid"        
                >
                    Save
                </v-btn>
            </div>
            <div>
                <v-btn
                    color="primary"
                    class="mb-2"
                    dark
                >
                    Close
                </v-btn>
            </div>
        </v-card-actions>
     </v-card>
    </v-form>
    </v-dialog>
</template>
<script>
import axios from '@/plugins/axios'
 export default {
    data() {
        return {
            user_type:[
                {type: 'Client', number:'0', icon:'mdi-alert-circle'},
                {type: 'Administrator', number:'1', icon:'mdi-alert-circle'},
            ],
             payload: {
                lastname: '',
                firstname: '',
                email: '',
                phone: '',
                user_type: '',
            },
            valid: true,
             firstnameRules: [
            v => !!v || 'First Name is required',
            v => (v && v.length <= 20) || 'First Name must be less than 20 characters',
            ],
            lastnameRules: [
            v => !!v || 'Last Name is required',
            v => (v && v.length <= 20) || 'Last Name must be less than 10 characters',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
             phoneRules: [
            v => !!v || 'Phone is required',
            v => (v && v.length <= 8) || 'Phone Number must be less than 9 characters',
            ],
            types: {type: 'Client', number:'0', icon:'mdi-alert-circle'},
           
        }
    },
    methods: {
        savenew(){
            // console.log(this.payload.user_type.number)
            this.payload.user_type = this.types.number
            // console.log(this.payload.user_type)
            axios.post('saveNew', this.payload).then(({response}) => {
              console.log(response.data)
            })
        },
        clearInput(){
            this.payload.lastname = ''
            this.payload.firstname = '' 
            this.payload.email = ''
            this.payload.phone = ''
        }
    },
     props: {
        dialog:{
            required: true,
            type: Boolean,
            default: false
        },
        id:{
            type:Number,
        }
    },
  
 }
</script>

<style>
    .card-text{
        padding-top: 5%; 
        padding-left: 5%;
    }
    .card-text-item {
        font-size: 150%;
    }
    .card-text-input {
        padding-left: 15%;
    }
    .card-text-button {
        padding-right: 3%;
    }
</style>