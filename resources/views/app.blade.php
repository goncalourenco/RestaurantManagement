@extends('master')

@section('title', 'Restaurant Management')

@section('content')

<v-app> 
    <v-toolbar app>
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title to="/">@{{title}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
            <template v-if="user==null">
                <v-btn to="/items" flat>Items</v-btn>
                <v-btn flat>Login</v-btn>
                <v-btn flat>Register</v-btn>
            </template>
            <template v-if="user">
            
            </template>                   
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