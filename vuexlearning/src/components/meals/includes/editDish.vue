<template>
    <div>
        <v-card
        height="500" 
        >
            <v-form
                ref="form"
                lazy-validation
                v-model="valid"
                class="padding"
            >
              
             
                    <span class="text">Edit Dish Information</span>
                    <!-- </template> -->
                     <v-flex xs10>
                            <div class="js--image-preview" style="margin: auto; padding-left: 30%; padding-top: 5%;">
                                <v-img
                                contain
                                style="width: 200px; height: 180px;"
                                 :src="payload.image ? payload.image : food_logo "
                                >
                                    
                                </v-img>
                                <!-- {{payload.image}} -->
                            </div>
                            <div class="upload-options" required style="padding-top: 15px;  padding-left: 29%;">
                                <label>
                                    <input type="file"
                                        id="fileData"
                                        @change="onFileChange"
                                        style="padding-left: 20%;"
                                        class="custom-file-input"
                                    />
                                </label>
                            </div>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field
                            v-model = "payload.name"
                            label="Name"
                            required                           
                        ></v-text-field>
                        </v-flex>
                         <v-flex xs12>
                            <v-text-field
                            v-model = "payload.description"
                            label="Description"
                            required                           
                        ></v-text-field>
                        </v-flex>
                         <v-card-actions>
                            <v-spacer></v-spacer>
                            <div class="card-text-button">
                                <v-btn
                                    color="#06aed5"
                                    class="mb-2"
                                    dark   
                                    @click = "editMeal()"
                                    :disabled="!valid"        
                                >
                                    Save
                                </v-btn>
                            </div>
                            <div>
                                <v-btn
                                    color="#06aed5 "
                                    class="mb-2"
                                    dark
                                    @click = "close()"
                                >
                                    Close
                                </v-btn>
                            </div>
                            <v-spacer></v-spacer>
                        </v-card-actions>


            </v-form>
        </v-card>
    </div>
</template>

<script>
import logo from '@/assets/images/logo.png'
// import axios from 'axios';
import food_logo from '@/assets/images/logo.png'
import { editMeal, editMealNoPic } from '@/repositories/meal.api'
export default {
     props: {
            item: {
                    type: Object,
                required: false,
            },
        
        },
    data() {
        return {
            payload: [],
            payload1: [],
            valid: true,
            logo,
            food_logo,
            drawer: true,
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

        editMeal(){
            const imageLabel = document.getElementById('fileData');

             if(imageLabel.value == ''){
                editMealNoPic(this.payload.id, this.payload).then(({res}) => {
                console.log(res)
                this.$emit('closeDrawer')
                })
             }
             else{
                editMeal(this.payload.id, this.payload).then(({res}) => {
                console.log(res)
                this.$emit('closeDrawer')

             })
             }

            // console.log
        },
        close(){
           this.$emit('closeDraw')
            // const imageInput = document.getElementById('fileData');
            // imageInput.value = ''
            // this.payload.description = ''
            // this.payload.name = ''

            // console.log("HAHAHAH")
        }

    },
    watch : {
        '$store.getters.newRequestedId'(newVal) {
            if(newVal) {
                console.log('IdRequest')
            }
        },
        'item'(){
            this.payload = JSON.parse(JSON.stringify(this.item))
        },
    }
}
</script>

<style>
.text{
    font-size: medium;
    font-weight: bold;
    padding-top: 30px;
}

</style>