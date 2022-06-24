

  
<template>
    <v-navigation-drawer
      :value="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
      style="top:8px !important; min-height:100vh !important;"
    >
      <v-img contain
        :src="logo"
        size="1"
        max-height="100"
        max-width="200"
        class="mx-auto"
      />
      <v-list dense>
        <template v-for="item in items">
          <v-row
            v-if="item.heading"
            :key="item.heading"
            align="center"
          >
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="item.text"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
          >
            <template v-slot:activator>
              <v-list-item
                >
                <v-list-item-content>
                  <v-list-item-title >
                    {{ item.text }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              link :to="child.url"
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
            v-else
            :key="item.text"
            link :to="item.url"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
      <template v-slot:append>
                <div class="pa-2"  style="padding-left: 30%;">
                    <template v-if="drawer">
                        <v-btn icon @click.stop="logout()">
                           <span> Logout </span>
                        </v-btn>
                    </template>
                    <template v-else>
                        <v-btn block @click.stop="logout">
                          Logout
                        </v-btn>
                    </template>
                </div>
            </template>
    </v-navigation-drawer>
</template>
<script>
  import logo from '@/assets/images/logo.png'
  export default {
    props: {
      source: String,
    },
    computed : {
      drawer(){
        return this.$store.state.sidebar
      }
    },
    data: () => ({
      logo,
      items: [
        { icon: 'mdi-view-dashboard', text: 'Dashboard' ,url:'/' },
        { icon: 'mdi-history', text: 'Purchases' ,url:'/purchases' },
        { icon: 'mdi-cart', text: 'Orders' ,url:'/orders' },
        { icon: 'mdi-food', text: 'Meals' ,url:'/meals' },
        { icon: 'mdi-food-fork-drink', text: 'Add Ons' ,url:'/addons' },
        { icon: 'mdi-cash-check', text: 'Payments' ,url:'/payments' },
   
        {
          icon: ' mdi-tools',
          'icon-alt': 'mdi-tools',
          text: 'Settings',
          model: false,
          children: [
            { icon: 'mdi mdi-account-edit', text: 'User Settings' , url:'/users'        
            },
            // { icon: 'mdi-account-group', text: 'View All User' , url:'/view'        
            // },
            // { icon: 'mdi mdi-account-check', text: 'Update User' , url:'/update'        
            // },
            // { icon: 'mdi mdi-account-remove', text: 'Delete User' , url:'/delete'        
            // },
          ],
        },
      ],
      newOrderRecords:0
    }),
    methods: {
       logout() {
        localStorage.setItem('token', '')
        location.reload();
      },
    },
    watch: {
      '$store.getters.newOrderRecords'(newVal) {
        this.newOrderRecords = newVal
      }
    }
  }
</script>
