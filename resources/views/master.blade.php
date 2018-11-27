<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        @yield('extrastyles') 
        <!-- Latest compiled and minified CSS & JS -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    </head> 
    <body>  
        <div class="container" id="app">
            <v-app>
                <v-toolbar>
                    <v-toolbar-side-icon></v-toolbar-side-icon>
                    <v-toolbar-title>@{{title}}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items class="hidden-sm-and-down">
                    <template v-if="user==null">
                      <v-btn flat>Items</v-btn>
                      <v-btn flat>Login</v-btn>
                      <v-btn flat>Register</v-btn>
                    </template>
                    <template v-if="user">
                      
                    </template>                   
                    </v-toolbar-items>
                  </v-toolbar>
            </v-app>
            @yield('content')
        </div>

     @yield('pagescript')  
     <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
  <script>    
    </body>
</html>