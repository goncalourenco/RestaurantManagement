@extends('master')

@section('title', 'Restaurant Management')

@section('content')
<v-app> 
    <menu-toolbar></menu-toolbar>
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