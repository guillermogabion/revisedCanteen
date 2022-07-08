<template>
  <div>

   

    <v-data-table
      :headers="headers"
      :items="meals"
      class="elevation-1"
      hide-default-footer
      :items-per-page="itemsPerPage"
      :loading="loading"
      :page.sync="page"
      @page-count="pageCount = $event"
      :server-items-length="total_meal"
      @pagination="fetchMealData"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>Dish List</v-toolbar-title>

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
        <v-dialog
            v-model="dialog"
            max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                  color="#f0c808"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>
                    mdi-plus
                  </v-icon>
                </v-btn>
              </template>
          </v-dialog>
        </v-toolbar>
      </template>

      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
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
     <addDialog
      :dialog="dialog"
      @close="close"
      @load ="reload"
      ></addDialog>
      <v-navigation-drawer
        right
        v-model="drawer"
        fixed
        width="500"
        height="500"
        @closeDrawer = "closeDrawer"
        @closeDraw = "closeDraw"
        temporary
      >
        <editDish :item="selected_item" @closeDrawer = "closeDrawer" @closeDraw = "closeDraw"/>
      </v-navigation-drawer>
       <v-snackbar
        v-model="snackbar2"
        :timeout="timeout"
        color="success"
        top 
        right
        >
          Updated
        </v-snackbar>
    
    </div>
</template>
  

<script>
import {mealPagination} from '@/repositories/meal.api'
import editDish from './includes/editDish.vue'
import addDialog from './includes/add.vue';
// import axios from '@/plugins/axios';
    export default {
      components : {
        addDialog,
        editDish
      },
        data() {
            return {
                headers: [
                    { text: 'Dish Name', value: 'name' },
                    { text: 'Description', value: 'description' },
                    { text: 'Options', value: 'actions' },
                ], 
                search: '',
                meals: [],
                dialog: false,
                selected_item : {},
                drawer: false,
                timeout: 1400,
                snackbar2: false,
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
          
            close(){
              this.dialog = false
             
            },
           
            editItem(item){
            this.selected_item = JSON.parse(JSON.stringify(item))
            this.$nextTick(()=> { 
              this.drawer = true;
            })
            },
             closeDraw(){
              this.drawer = false
            },
            closeDrawer(){
              this.snackbar2 = true
              this.drawer = false
              this.indexMeal()
            },
            reload(){
               this.indexMeal();
            }
        },
       
      
         props:{
          'data' : {}
        },
    }

</script>