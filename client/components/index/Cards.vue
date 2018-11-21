<template>
    <div id="content">
        <div class="container">
            <template v-for="type of types">
                <div class="subject">
                    <div class="theme">
                        <img :src="address+'/client/static/img/'+type.ename+'.png'" :alt="type.cname"/>
                        <span class="title">{{type.cname}}</span>
                    </div>
                    <div class="card-wrap">
                        <div v-for="s of subjects[type.ename]" class="item" :data-url="s.url" @click="play">
                            <img :src="address+'/client/static/'+s.img" :alt="s.title">
                            <div class="item-body">
                                <h6 :title="s.title">{{s.title}}</h6>
                                <span :title="s.desc">{{s.desc}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        name: "Card",
        props: {
            types: {
                type: Array,
                required: true
            },
            subjects: {
                type: Object,
                required: true
            }
        },
        computed:mapState(['address']),
        methods:{
            play(e){
                if('url' in e.currentTarget.dataset){
                    this.$router.push(`/video/${e.currentTarget.dataset.url}`);
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .container{
        padding-top:1.5rem;
        padding-bottom:106px;
        margin:0 auto;
    }

    #content{
        background:linear-gradient(-45deg,#fb3 7%,#58a 0,#58a 20%,#fccd04 0,#fccd04 35%,#dc143c 0,#dc143c 50%,#fb3 0,#fb3 57%,#58a 0 ,#58a 70%,#fccd04 0,#fccd04 85%,#dc143c 0);
        background-size:550px 550px;
        transition:background-position .25s ease-out,background-size .25s ease-out;
    }
    .subject{
        margin-bottom:2rem;
        min-width:1140px;
        .theme {
            display: flex;
            align-items: flex-end;
            margin-bottom:.5rem;
            img{
                height:40px;
            }
            .title {
                font-size: 1.8rem;
                margin: 0 15px;
            }
            .description{
                color:darkgray;
                margin-left:.5rem;
            }
        }
        .card-wrap {
            display: flex;
            justify-content: space-between;
            .item {
                margin: 0 3px;
                cursor: pointer;
                transition: margin .25s linear;
                border: 1px solid rgba(255, 255, 255, 0.125);
                display: flex;
                flex-direction: column;
                border-radius: 5px;
                cursor: pointer;
                img{
                    width:100%;
                    border-top-left-radius:2px;
                    border-top-right-radius:2px;
                    border:none;
                }
                &:hover {
                    transform-origin: center bottom;
                    margin: 0 15px;
                    transform: scale(1.3, 1.15);
                    z-index: 2;
                }
                .item-body {
                    padding: .5rem;
                    font-size: .9rem;
                    flex: 1 1 auto;
                    background: white;
                    opacity: .9;
                    span{
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }
                    h6{
                        font-weight:600;
                        display: -webkit-box;
                        -webkit-line-clamp: 1;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        text-align:center;
                        margin-bottom:.3rem;
                    }
                }
            }
        }
    }
</style>