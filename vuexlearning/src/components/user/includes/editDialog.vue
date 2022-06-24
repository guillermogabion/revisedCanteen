 <template>
    <div>
        <v-card
        >
            <v-form
            ref="form"
            lazy-validation
            v-model="valid"
            class="padding"
          
        >
      <v-card
      height = "500"
      >
        <div class="card-text">
            <span class="card-text-item"> Edit User's Information</span>
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
                            persistent-hint return-object prepend-icon="mdi-account-key" label="User Type">
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
                    @click = "editUser()"
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
                    @click = "close()"
                >
                    Close
                </v-btn>
            </div>
        </v-card-actions>
     </v-card>
    </v-form>
    <!-- <v-snackbar
    v-model="snackbar"
    :timeout="timeout"
    color="success"
    top 
    right
    >
      Updated
    </v-snackbar> -->
        </v-card>
    </div>
 </template>

 <script>
    // import axios from '@/plugins/axios'
 import { editUser } from '@/repositories/user.api'
    export default {
        
        props: [ 'item' ],
        data() {
            return {
                snackbar: false,
                timeout: 1400,
                drawer: true,
                payload: [],
                 user_type:[
                {type: 'Client', number:'0', icon:'mdi-alert-circle'},
                {type: 'Administrator', number:'1', icon:'mdi-alert-circle'},
            ],
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
            types:'',
            }
        },
        methods: {
            editUser(){
                this.payload.user_type = this.types.number
                editUser(this.payload.id, this.payload).then(({res}) => {
                    console.log(res)
                    //  this.snackbar = true
                     this.$emit('closeDrawer')
                })
            }, 
            close(){
                this.$emit('closeDraw')
            }
        },
        watch: {
        '$store.getters.newRequestedId'(newVal) {
            if(newVal) {
            console.log('sad')
            }
        },
        'item'() {
            this.payload = JSON.parse(JSON.stringify(this.item))
        },
     }
    }
 </script>