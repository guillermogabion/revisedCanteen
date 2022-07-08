<template>
    <div>

    
    <v-card
      height="797px" 
      class="scroll"
    >
      <v-card-actions>
        <v-spacer></v-spacer>
          <v-btn
            color="#f0c808"
            dark
            class="mb-2"
            @click = "drawer = true"            
          >
            <v-icon>
              mdi-plus
            </v-icon>
          </v-btn>
      </v-card-actions>
      <v-row class="ma-1"> 
        <v-col v-for="item in scheduleDish" :key="item.id"
          cols="16" :lg="2" :sm="8" :md="2" :xs="10"
          class=' elevation-1'
        >
          <v-card
            class="mx-auto"
            max-width="280"
            max-height="310"
            min-height="340"
          >
           
            <v-responsive class="image_container" height="10%">
              
              <div
              class="image-padding"
             
              >
                <v-img
                  contain
                  :alt="item.dish[0].image"
                  :src="item.dish[0].image? item.dish[0].image : food_logo"
                  class="image-padding"
                  padding-left="2em" 
                  max-height="150"
                  max-width="200"
                ></v-img>
              </div>
            </v-responsive>
           
            <v-card-title>
              {{item.dish[0].name}}
            </v-card-title>  
            <v-card-text class="description">
              Description: {{item.dish[0].description}}<br>
              Price: <span style="font-weight: bold;"> {{item.price}} </span>
            </v-card-text> 
            <v-card-actions>
            <v-spacer></v-spacer> 
              <v-btn
               color="success"
               text
              >
                Reserve
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-card>
    <v-navigation-drawer
        right
        v-model="drawer"
        fixed
        width="800"
        height="900"
       
        temporary
      >
        <AddSchedule :item="selected_item" @reload="load"/>
      </v-navigation-drawer>
    </div>
</template>

<script>
import {getScheduledDish} from '@/repositories/schedule.api'
import food_logo from '@/assets/images/logo.png'
import AddSchedule from './includes/addSched.vue'
// import axios from '@/plugins/axios';
export default {
  components : {
    AddSchedule
  },
    data() {
        return {
            scheduleDish: [],
            food_logo,
            drawer: false,
            selected_item : {},
        }
    },
    mounted() {
        this.getAll()
    },
    methods: {
        getAll(){
            getScheduledDish().then(response =>{
                this.scheduleDish = response.data.data
                console.log(response.data)
            })
        },
        load(){
          this.getAll()
        }
    },
}



</script>

<style>
.image-padding {
  padding-left: 3.5em; 
  padding-top: 1em;
}
</style>