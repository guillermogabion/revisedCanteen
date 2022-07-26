<template>
    <v-dialog
    v-model="dialog"
    persistent
    max-height="400" 
    max-width="400"
    min-height="500" 
    min-width="29%"
    >
        <v-card
            width="350"
            class="over"
        > 
        <v-card-title class="grey" width="350">
            <v-card-text class="texts">Add New Dish</v-card-text>
                
        </v-card-title>
            <v-form
                ref="form"
                lazy-validation
                v-model="valid"
                class="padding"
            >
              
                  
                        <v-flex xs10>
                            <div class="js--image-preview" style="margin: auto; padding-left: 30%; padding-top: 5%;">
                                <v-img
                                contain
                                 style="width: 200px; height: 134px;"
                                 :src="payload.image || logo"
                                >
                                </v-img>
                            </div>
                            <div class="upload-options" required style="padding-top: 15px;  padding-left: 25%;">
                                <label>
                                    <input type="file"
                                            id="fileData"
                                            @change="onFileChange"
                                            style="padding-left: 20%;"
                                            class="custom-file-input"
                                    />
                                </label>
                                <!-- <v-file-input
                                    id="fileData"
                                    @change="onFileChange"
                                    style="padding-left: 20%;"
                                ></v-file-input>     -->
                            </div>
                        </v-flex>
                        <v-flex xs10>
                            <div style="padding-left: 20%;">
                                <v-text-field
                                v-model = "payload.name"
                                label="Dish Name"
                                required
                                :rules="dishNameRules"
                                ></v-text-field>
                            </div>
                        </v-flex>
                        <v-flex xs10>
                            <div style="padding-left: 20%;">
                                <v-text-field
                                v-model = "payload.description"
                                label="Description"
                                required
                                :rules="descriptionRules"
                            ></v-text-field>
                            </div>
                        </v-flex>
            
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <div style="padding-right: 2%;">
                         <v-btn
                            color="primary"
                            small
                            dark
                            width="70px"
                            @click = "addMeal()"
                            :disabled="!valid"
                        >
                            Save
                        </v-btn>
                    </div>
                    <div>
                        <v-btn
                            color="primary"
                            dark
                            small
                            width="70px"
                            @click.prevent="$emit('close')"
                            @click="reset()"
                        >
                            Close
                        </v-btn>
                    </div>
                     <v-spacer></v-spacer>
                </v-card-actions>
            </v-form>
        
        </v-card>
       
    </v-dialog>
</template>

<script>
import logo from '@/assets/images/logo.png'
import axios from '@/plugins/axios'
export default {
    data() {
        return {
            valid: true,
            logo,
            payload: {
                image: '',
                name: '',
                description: ''
            },
             dishNameRules: [
            v => !!v || 'Dish Name is required',
            
            ],
             descriptionRules: [
            v => !!v || 'Dish Description is required',
            ],
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
    methods: {
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            this.createImg(files[0]);
        },
        createImg(file){
            // var image = new Image;
            var reader = new FileReader; 

            reader.onload = (e) => {
                this.payload.image = e.target.result;
                };
            reader.readAsDataURL(file)
        },
        reset(){
            this.$refs.form.resetValidation()
            const imageInput = document.getElementById('fileData');
            imageInput.value = ''
            this.payload.description = ''
            this.payload.name = ''
        },
        addMeal(){
            // console.log(this.payload)
            axios.post('addMeal', this.payload).then((res) => {
                console.log(res)
                this.$emit('close')
                this.$emit('load')
            })
        }
    }
}
</script>
<style>
.custom-file-input {
  color: transparent;
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
  content: 'Select Image';
  color: black;
  display: inline-block;
  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;
}
.custom-file-input:hover::before {
  border-color: black;
}
.custom-file-input:active {
  outline: 0;
}
.custom-file-input:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9); 
}
.over{
 overflow-y: hidden;   
}
.texts {
    font-size: medium;
    font-weight: bold;
}
</style>