<script setup>

    defineProps({
        title: {
            type: String,
            required: true,
        },
        content: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        }
    });

    
</script>

<template>
    <div class="cloud">
        <h2 class="title_cloud">{{ title }}</h2>
        <p class="content_cloud">{{ content }}</p>
    </div>
    <div class="pad">
        <router-link class="open_" :to ="/BigPostView/ + title + '/' + content + '/' + id">Open Cloud</router-link>
        <!-- <router-link class="open" :to = "/BigPostView/ + id" >Open Cloud</router-link> -->
    </div>
</template>











<style scoped>
.post {
    padding: 30px;
}
.open_ {
    color: palevioletred;
    
}
.pad{
    padding-bottom: 10px;
}
.cloud{
    padding: 15px;
    overflow: hidden;
}
.title_cloud{
    font-family: 'Roboto';
    display: inline-block;
    text-transform: uppercase;
    background-color: hsl(309, 100%, 89%);
    border-radius: 15px;
    border: 4px double #cccccc;
    color: #bf6fbf;
    text-align: center;
    font-size: 13px;
    font-weight: 500;
    padding: 3px;
    min-width: 150px;
    width: fit-content;
    transition: all 0.5s;
    margin-top: 10px;
    margin-bottom: 30px;
    box-shadow: rgb(85, 91, 255) 0px 0px 0px 3px, rgb(31, 193, 27) 0px 0px 0px 6px, rgb(255, 217, 19) 0px 0px 0px 9px, rgb(255, 156, 85) 0px 0px 0px 12px, rgb(255, 85, 85) 0px 0px 0px 15px;
    }
.content_cloud{
    /* display: flex;
    flex-direction: row; */
    line-height: 15px;
    text-align: center;
    border: none;
    resize: none;
    box-sizing: border-box;
    width     : 180px;
    height    : 180px;
    padding   : 97px 1em 0px 1em;
    color:rgb(108, 87, 129, 0.7);

    padding-bottom: 10px;
 

    margin    : 0 100px;

    position: relative;

    
    background-color: #aeebff;


    border-radius: 100% 100% 0 0;
    
}

.content_cloud::before,
.content_cloud::after{

    content: '';

    position: absolute;
    bottom  : 0px;


    z-index : -1;

    background-color: #aeebff;
    border-radius: 100%;
    }

.content_cloud::before{

    width  : 135px;
    height : 135px;


    left    : -80px;

    border-bottom-right-radius: 0;
    }

.content_cloud::after{

    width  : 115px;
    height : 115px;


    right   : -60px;


    border-bottom-left-radius: 0;
    }

</style>