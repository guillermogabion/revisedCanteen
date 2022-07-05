<template>
  <div>

     <v-navigation-drawer
        right
        v-model="drawer"
        fixed
        width="500"
        height="500"
        temporary
      >
        <UserEdit :item="selected_item" @closeDrawer = "closeDrawer" @closeDraw = "closeDraw"/>
      </v-navigation-drawer>

    <v-data-table
      :headers="headers"
      :items="users"
      class="elevation-1"
      hide-default-footer
      :items-per-page="itemsPerPage"
      :loading="loading"
      :page.sync="page"
      @page-count="pageCount = $event"
      :server-items-length="total_user"
      @pagination="fetchUserData"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>User Record</v-toolbar-title>

          <v-spacer></v-spacer>
          <v-text-field
                label="Search"
                filled
                rounded
                dense
                style="padding-top: 40px; padding-right: 10px;"
                v-model="search"
                :items='users'
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
        <v-icon
          small
          @click="deleteItem(item)"
        >
          mdi-delete
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
      <v-dialog
        transition="dialog-top-transition"
        max-width="400"
        v-model="dialogDelete"
      >
      <v-card>
       <v-toolbar
          color="error"
          dark
        >
           Alert 
        </v-toolbar>
        <v-card-text>
              <div class="text-h4 pa-12">Confirm Delete?</div>
        </v-card-text>
         <v-card-actions class="justify-end">
            <v-btn
              @click="deleteUser()"
              text
            >Okay</v-btn>
            <v-btn
              text
              @click="dialogDelete = false"
            >Cancel</v-btn>
          </v-card-actions>
      </v-card>
      </v-dialog>

        <!-- <pagination align="center" :data="employees" @pagination-change-page="list"></pagination> -->
      </div>
     <addDialog
      :dialog="dialog"
      @close="close()"
      @reload="reload()"
      ></addDialog>

    <v-snackbar
    v-model="snackbar"
    :timeout="timeout"
    color="success"
    top 
    right
    >
      Success
    </v-snackbar>

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
import { userPagination, searchUser, deleteUser  } from '@/repositories/user.api'
import addDialog from './includes/dialog.vue';
import UserEdit from './includes/editDialog.vue'

    export default {
      components : {
        addDialog,
        UserEdit
      },
        data() {
            return {
                headers: [
                    { text: 'ID', value: 'id' },
                    { text: 'Lastname', value: 'lastname' },
                    { text: 'Firstname', value: 'firstname' },
                    { text: 'Email', value: 'email' },
                    { text: 'Phone No.', value: 'phone' },
                    { text: 'Actions', value: 'actions', sortable: false },
                ], 
                snackbar: false,
                snackbar2: false,
                timeout: 1400,
                loading: false,
                users: [],
                dialog2:false, 
                dialog:false,
                selected_item : {},
                drawer: false,
                pageCount: 0,
                itemsPerPage:null,
                total_user:0,
                page:1,
                current_page:0,
                search: '',
                editedIndex: -1,
                editedItem: {
                  id: '',
                  lastname: '',
                  firstname: '',
                  email: '',
                  phone: '',
                },
                dialogDelete: false,

              }
        },
         watch: {
          "search": {
              handler(val) {
                this.indexUser(val)
              },
              deep: true,
            },
        },
        methods: {
            // getUser(){
            //     axios.get('index').then((res) => {
            //         this.users = res.data
            //         console.log(res)
            //     });
            // },
            reload(){
              this.indexUser();
            },
            deleteItem(item){
              this.editedIndex = this.users.indexOf(item)
              this.editedItem = Object.assign({}, item)
              this.dialogDelete = true
          
            },
            deleteUser(){
              deleteUser(this.editedItem.id).then((res)=> {
                console.log(res)
                this.indexUser();
                this.dialogDelete = false
                this.snackbar = true
              })
            },
            close(){
              this.dialog = false
            },
            closeDraw(){
              this.drawer = false
            },
            closeDrawer(){
              this.snackbar2 = true
              this.drawer = false
              this.indexUser();
            },
            editItem(item){
              this.selected_item = JSON.parse(JSON.stringify(item))
              this.$nextTick(()=> {
                this.drawer = true;
              })
            },
            set_data_fromServer(data) {
              this.users = data.data
              this.total_user = data.total
              this.itemsPerPage = data.per_page
              this.pageCount = data.last_page
            },
            fetchUserData(page){
              this.current_page = page.page
              this.indexUser()
            },
            indexUser(){
               this.url = 'users/pagination?page='+this.current_page+ '&keyword=' +this.search
               this.loading = true
                if (this.timer) {
                  clearTimeout(this.timer);
                  this.timer = null;
                }
                this.timer = setTimeout(() => { 
                  userPagination(this.url).then(({data}) => {
                    console.log(this.url,"index")
                    this.set_data_fromServer(data)
                    this.loading = false
                  })
                }, 800);
            },
            searchUser(key) {
              if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
              }
              this.timer = setTimeout(() => {
                searchUser({searchkey:key}).then((response) => {
                  this.users = response.data 
                }).catch((errors) => {
                  console.log(errors)
                });
              },800);
            },
            

        },
       
      
         props:{
          'data' : {}
        },
    }

</script>