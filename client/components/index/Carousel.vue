<template>
    <div class="carouselWrapper">
        <div class="slider_nav">
        <a v-for="(c,index) of carousel" :class="['nav-link',{'active':!index}]" @click @mouseenter="stopSlide(index,$event)" @mouseleave="slide"><span>{{c.name}}：{{c.description}}</span></a>
        </div>
        <div class="site_slider">
            <a class="slider_item" :class="flag?'in':'out'" target = "_blank" ref="in"></a>
            <a class="slider_item" :class="flag?'out':'in'"target = "_blank" ref="out"></a>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            carousel:{
                type:Array,
                required:true
            }
        },
        name: "Carousel",
        data(){
            return {
                timer:null,
                currentIndex:0,
                flag:true
            }
        },
        methods:{
            slide:function(event){
                clearInterval(this.timer);
                this.timer=setInterval(()=>{
                    if(this.currentIndex+1>this.carousel.length-1){
                        this.currentIndex=0;
                    }else{
                        this.currentIndex++;
                    }
                },3000);
            },
            stopSlide:function(index,e){
                e.stopPropagation();
                clearInterval(this.timer);
                this.currentIndex=index;
            }
        },
        watch:{
            currentIndex:function(){
                this.flag = !this.flag;
                setTimeout(()=>{
                    document.querySelector('.in').style.backgroundImage=
                        `url(http://localhost/client/static/${this.bgImages[this.currentIndex]})`;
                },0)
            }
        },
        computed:{
            bgImages:function(){
                return this.carousel.map(item=>item.img)
            }
        },
        mounted(){
            this.slide();
            document.querySelector('.in').style.backgroundImage=
                `url(http://localhost/client/static/${this.bgImages[this.currentIndex]})`;
        }
    }
</script>

<style scoped lang="scss">
    .carouselWrapper{
        position:relative;
        height:580px;
        background-color:white;
    }
    .slider_nav{
        display: flex;
        z-index: 2;
        justify-content: space-evenly;
        flex-direction: column;
        height:85%;
        width:20%;
        min-width:280px;
        position: absolute;
        right:0;
        background:rgba(255,255,255,.6);
        top:15%;
        a{
            text-decoration: none;
            text-align:center;
            cursor:pointer;
            color:#5600ff;
            font-weight:bold;
        }
    }
    .site_slider{
        height:100%;
        position:absolute;
        top:0;
        width:100%;
    }
    .slider_item{
        /*position:absolute;*/
        display: block;
        width:100%;
        height:100%;
        background-position:center 0;
        background-repeat:no-repeat;
        transition:opacity .5s ease-in;
        margin:0;
        position:absolute;
        background-size: cover;
    }
    .in{
        opacity: 1;
        z-index: 1;
    }
    .out{
        opacity: 0;
        z-index: 0;
    }
</style>