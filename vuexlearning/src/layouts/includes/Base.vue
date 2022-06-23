<template>

    <div>
        
        <Sidebar/>
        <v-app-bar app>
             <v-app-bar-nav-icon @click="toggle"></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
            <Profile/>
        </v-app-bar>
  
        <!-- <v-app-bar app>
        
            <v-icon>mid-heart</v-icon>
            <v-toolbar-title>Vue Practice</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-app-bar> -->
        <v-main >
            <router-view></router-view>
        </v-main>
    </div>
</template>

<script>
import Sidebar from './Sidebar.vue'
import Profile from './Profile.vue'

export default {
    components: {
        Sidebar,
        Profile
 
    },

    methods: {
         toggle() {
        this.$store.commit('toggleSideBar')
        console.log(this.$store.state.sidebar, 'sidebar')
      },
    },
}
</script>