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
                height="500"
                >
                    <v-toolbar
                        color="Green"
                        dark
                        >
                        Edit Dish Information
                    </v-toolbar>
                     <v-flex xs12>
                            <div class="js--image-preview" style="margin: auto; padding-left: 30%; padding-top: 5%;">
                                <v-img
                                 style="width: 200px; height: 180px;"
                                 :src="payload.image "
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
                        <v-flex xs10>
                            <v-text-field
                            v-model = "payload.name"
                            label="Name"
                            required                           
                        ></v-text-field>
                        </v-flex>

                </v-card>

            </v-form>
        </v-card>
    </div>
</template>

<script>
import logo from '@/assets/images/logo.png'
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
            valid: true,
            logo,
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