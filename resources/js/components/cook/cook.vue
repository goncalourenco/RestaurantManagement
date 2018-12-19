<template>
    
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.getOrders();
        },
        data(){
            return{
                orders: []
            }
        },
        methods:{
            getOrders: function(){
                axios.get("api/orders").then(response => {
                this.orders = response.data.data;
                console.log(response.data.data);
            });
        }
    }
}

</script>