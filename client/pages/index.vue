<template>
    <div>
        <Carousel v-if="carousel" :carousel="carousel"/>
        <Cards v-if="types&&subjects" :types="types" :subjects="subjects"></Cards>
    </div>
</template>

<script>
    import axios from 'axios';
    import Carousel from '~/components/index/Carousel'
    import Cards from '~/components/index/Cards'
    export default {
        name: "index",
        components:{
            Carousel,
            Cards,
        },
        async asyncData(){
            const {data} = await axios.get('/public');
            return {...data};
        },
        data(){
            return {
                carousel:null,
                types:null,
                subjects:null
            }
        }
    }
</script>

<style scoped>

</style>