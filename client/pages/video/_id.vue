<template>
    <div v-if="video">
        <div style="width:100%;padding-left:1rem;">
            <h1 class="text-white">视频：{{video['videoName']}}</h1>
        </div>
        <div id="container">
            <vue-plyr>
                <video controls crossorigin playsinline id="player">
                    <template v-for="(value,key) in resolution">
                        <source v-if="video[key]" :src="'http://localhost/'+video[key]" type="video/mp4" :size="key | trim">
                    </template>
                    <track kind="metadata" :src="'http://localhost/storage/app/uploads/formatted/'+video.url+'.vtt'" default>
                </video>
            </vue-plyr>
        </div>
        <span id="thumb"></span>
        <button class="btn btn-info" style="width:100%;text-align: left" data-toggle="collapse" data-target="#videoDesc"
                id="desc-btn">视频简介(点击以展开)
            <strong class="text-white" id="desc-span" style="float:right;margin-right:.3rem;">+</strong></button>
        <div class="collapse" id="videoDesc">
            <div class="card card-body">
                {{video['videoDesc']}}
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import 'vue-plyr/dist/vue-plyr.css';

    export default {
        name: "Video",
        data() {
            return {
                video: null,
                resolution: null,
                comments: null,
            }
        },
        // async asyncData({route}){
        //     const {data} = await axios.get(`/public/video/${route.params.id}`,{
        //         headers: {
        //             'Access-Control-Allow-Origin': '*',
        //         },
        //     });
        //     return {...data};
        // },
        async asyncData({route}){
            const {data} = await axios.get(`/public/video/${route.params.id}`);
            return {...data};
        },
        // async created(){
        //     const {data} = await axios.get(`/public/video/${this.$route.params.id}`);
        //     console.log(data);
        //     Object.assign(this.$data,data);
        // },
    }
</script>

<style lang="scss" scoped>
</style>