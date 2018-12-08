@extends('master')

@section('title', 'Restaurant Management')

@section('content')
<v-app> 
    <v-toolbar app>
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title>
                <router-link to="/">Restaurant Management</router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
            <v-btn to="/items" flat>Items</v-btn>
            <template v-if="!this.$store.state.user">
                <v-btn flat to="/login">Login</v-btn>
            </template>   
            <template v-if="this.$store.state.user">
                <v-btn flat @click="logout">Logout</v-btn>
                </template>              
            <!--<router-link to="/login"  v-show="!this.$store.state.user">Login</router-link> -->
            <!--<router-link to="/logout" v-show="this.$store.state.user">Logout</router-link>-->
            </v-toolbar-items>
    </v-toolbar>
    <v-content>
        <v-container fluid>
            <router-view></router-view>
        </v-container>
    </v-content>
    <v-footer app></v-footer>
</v-app>
@endsection

@section('pagescript')
<script src="js/app.js"></script>    
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
 @stop  