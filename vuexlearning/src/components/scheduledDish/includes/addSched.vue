<template>
    <div
    min-height="500" 
    min-width="100">
         <v-card
        min-height="500" 
        min-width="100"
        >
         
        <v-card
        class="size"
        >
            <v-data-table
            
                :headers="headers"
                :items="meals"
                class="elevation-1"
                @click:row="(item)=> editItem(item) "
                hide-default-footer
                :items-per-page="itemsPerPage"
                :loading="loading"
                :page.sync="page"
                @page-count="pageCount = $event"
                :server-items-length="total_meal"
                @pagination="fetchMealData"
                :mobile-breakpoint="0"
            > 
                <template v-slot:top>
                 <v-toolbar
                    flat
                    >
                    <v-toolbar-title>List of Dish</v-toolbar-title>      
                        <v-spacer></v-spacer>
                        <v-text-field
                        label="Search"
                        filled
                        rounded
                        dense
                        style="padding-top: 40px; padding-right: 10px;"
                        v-model="search"
                        :items='meals'
                    ></v-text-field>
                 </v-toolbar>
            </template>
            <!-- <template v-slot:item.actions="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
            >
                mdi-pencil
            </v-icon>
        
            </template> -->
            <template v-slot:item.image="{ item }">
                <v-avatar
                    tile
                    size="50px"
                    class="my-2"
                >
                    <v-img
                        :alt="item.image"
                        max-height="150"
                        max-width="250"
                        :src="item.image ? item.image : logo"
                    ></v-img>
                </v-avatar>
            </template>
            </v-data-table>
            <div class="text-center pt-2">
                <v-pagination
                v-model="page"
                circle
                :total-visible="7"
                :length="pageCount"
            ></v-pagination>
            </div>
            </v-card>
        </v-card>
         <v-dialog
            v-model="dialog"
            persistent
            min-width="15%"
            min-height="50%"
            width="500"
            >
            <v-card>
                <div class="padding">
                <span>Set Schedule Date</span>
                </div>
                <div style="padding-left: 10%; padding-top: 5%;">
                    <v-img
                        contain
                        :alt="editedItem.image"
                        min-width="40%"
                        max-height="150"
                        max-width="88%"
                        :src="editedItem.image ? editedItem.image : logo"
                    ></v-img>
                </div>
                <v-card-title
                class="font-title"
                >
                    {{editedItem.name}}
                </v-card-title>
                <v-card-text>
                    <span class="font-text">{{editedItem.description}}</span>
                </v-card-text>
                <div
                 padding="10%"
                >
                    <v-text-field
                    class="pa-6 ma-1"
                        v-model=" editedItem.price"
                        label="Price"
                    ></v-text-field>
                </div>
                <div
                class="padding pa-6 ma-1"
                >
                    <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model=" date"
                            label="Set Date Scheduled"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="date"
                        @input="menu2 = false"
                        ></v-date-picker>
                    </v-menu>
                </div>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                    text
                    color="success"
                    @click="save()"
                    >
                        Save
                    </v-btn>
                    <v-btn
                    text
                    color="error"
                    @click = "dialog = false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>
        <!-- <addDialog
        :dialog="dialog"
     
        ></addDialog> -->
    </div>
</template>

<script>
// import {getScheduledDish} from '@/repositories/schedule.api'
import {mealPagination, } from '@/repositories/meal.api'
import {addDishSchedule } from '@/repositories/schedule.api'
// import axios from '@/plugins/axios'
import logo from '@/assets/images/logo.png'
// import addDialog from './addSchedDialog.vue'

    export default {
        components: {
            // addDialog
        },
        data() {
            return {
                date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
                headers : [
                    { text: '', value: 'image', align: 'start' },
                    { text: 'Dish', value: 'name', align: 'center' },
                    { text: 'Description', value: 'description', align: 'center' },
                ],
                search: '',
                meals: [],
                dialog: false,
                editedIndex: -1,
                menu2: false,
                logo,
                editedItem: {
                    id: '',
                    name: '',
                    price: '',
                    description: '',
                    image: '',
                    
                },
                pageCount: 0,
                itemsPerPage:null,
                total_meal:0,
                page:1,
                current_page:0,
                loading: false,

            }
        },
         watch: {
          "search": {
              handler(val) {
                this.indexMeal(val)
              },
              deep: true,
            },
        },
        methods: {
              indexMeal(){
               this.url = 'meals/pagination?page='+this.current_page+ '&keyword=' +this.search
               this.loading = true
                if (this.timer) {
                  clearTimeout(this.timer);
                  this.timer = null;
                }
                this.timer = setTimeout(() => { 
                  mealPagination(this.url).then(({data}) => {
                    console.log(this.url,"index")
                    this.set_data_fromServer(data)
                    this.loading = false
                  })
                }, 500);
            },
            fetchMealData(page){
                this.current_page = page.page
                this.indexMeal()
            },
            set_data_fromServer(data) {
                this.meals = data.data
                this.total_meal = data.total
                this.itemsPerPage = data.per_page
                this.pageCount = data.last_page
            },
            editItem (item) {
                this.editedIndex = this.meals.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            save(){
                this.editedItem.date = this.date
                addDishSchedule(this.editedItem).then((res)=> {
                    console.log(res)
                    this.$emit('reload')
                    this.dialog = false
                })
            }
           
        },
        
    }
</script>
<style>
.font-title{ 
    font-weight: bolder;
    font-size: 20px;
}
.font-text {
    font-weight: bold;
    font-size: 15px;
}
.padding{
    padding-top: 5%;
    font-weight: bold;  
}
.padding-text{
    padding-top: 3%;
    padding-left: 3%;
    font-weight: bold;
    font-size: 20px;  

}
.size {
    padding: 5%;
}
</style>