<template>
    <div class="video-page-container">
        <div v-if="video">
            <div class="title" style="">
                <h1 class="text-white">视频：{{video['videoName']}}</h1>
            </div>
            <div id="container">
                <vue-plyr>
                    <video controls crossorigin playsinline id="player" ref="video">
                        <template v-for="(value,key) in resolution">
                            <source v-if="video[key]" :src="address+video[key]" type="video/mp4"
                                    :size="key | trim">
                        </template>
                        <track kind="metadata" :src="address+'/storage/app/uploads/formatted/'+video.url+'.vtt'"
                               default>
                    </video>
                    <span id="thumb" ref="thumb"></span>
                </vue-plyr>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { mapState } from 'vuex';
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
        computed:mapState(['address']),
        // async asyncData({route}){
        //     const {data} = await axios.get(`/public/video/${route.params.id}`,{
        //         headers: {
        //             'Access-Control-Allow-Origin': '*',
        //         },
        //     });
        //     return {...data};
        // },
        async asyncData({route}) {
            const {data} = await axios.get(`/public/video/${route.params.id}`);
            return {...data};
        },
        // async created(){
        //     const {data} = await axios.get(`/public/video/${this.$route.params.id}`);
        //     console.log(data);
        //     Object.assign(this.$data,data);
        // },
        mounted(){
            /*******************************************************************/
            //显示thumbnail
            const self = this;
            let video = this.$refs.video;
            let bar = document.querySelector('input[id^="plyr-seek"]');
            let thumb = this.$refs.thumb;
            let track = video.textTracks[0];
            let cues;
            setTimeout(function(){
                cues = track.cues;
            },0)

            function show() {
                thumb.style.visibility = 'visible';
            };

            function hide() {
                thumb.style.visibility = 'hidden';
            };

            function getOffset(el) {
                const rect = el.getBoundingClientRect();
                return {
                    left: rect.left + window.scrollX,
                    top: rect.top + window.scrollY
                };
            }

            function render(e) {
                let bar_width = bar.offsetWidth;
                if(!cues||!cues.length){
                    return
                }
                var p = (e.pageX - getOffset(bar).left) * video.duration / bar_width;
                for (var i = 0; i < cues.length; i++) {
                    if (cues[i].startTime <= p && cues[i].endTime > p) {
                        break;
                    }
                    ;
                }
                var xywh = cues[i].text.substr(cues[i].text.indexOf("=") + 1).split(',');
                thumb.style.backgroundImage = 'url('+self.address+'/storage/app/uploads/formatted/' + cues[i].text.split('#')[0] + ')';
                thumb.style.backgroundPosition = '-' + xywh[0] + 'px -' + xywh[1] + 'px';
                thumb.style.left = e.pageX - xywh[2] / 2 + 'px';
                thumb.style.top = getOffset(bar).top - xywh[3] - 10 + 'px';
                thumb.style.width = xywh[2] + 'px';
                thumb.style.height = xywh[3] + 'px';
            };
            bar.addEventListener('mousemove', render);
            bar.addEventListener('mouseover', show);
            bar.addEventListener('mouseout', hide);
            /*******************************************************************/
        }
    }
</script>

<style lang="scss" scoped>
    .video-page-container {
        background-color: #007bff;
        height:100%;
        display: flex;
        justify-content: center;
        padding-bottom:2rem;
        .title{
            width:100%;
            padding-top:2rem;
            padding-bottom:1.5rem;
        }
        #container{
            width:800px;
        }
        #thumb {
            display: block;
            position: absolute;
            visibility: hidden;
            background-color: #000;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            /*z-index: 1000;*/
            z-index:auto;
        }
    }
</style>