<script>
import { isSVGTag } from '@vue/shared';
import router from '../router';

export default {
    data(){
        return {
            title: this.title,
            content: this.content,
        };
    },
    methods: {
        deleteCloud(){ 
            fetch('http://5.135.119.239:3090/notes/' + this.$route.params.id, {
                method: 'DELETE',
                headers: {"Content-Type": "application/json",
                }
            })
            .then(response=>{
                if(response.ok == true){
                    this.$toast.success("Celle ci sera oubliée...")
                    this.$router.push({name : 'postit'})
                }
            });
        },
        editCloud(){
            console.log("toto");
            fetch('http://5.135.119.239:3090/notes/' + this.$route.params.id, {
                method: 'PUT',
                headers: {"Content-Type": "application/json",
                },
                body: JSON.stringify({title: this.title, content: this.content,
                }),
            })
            .then((response) => {
                if (response.ok){
                    console.log("tututu");
                    this.$toast.success("Tout le monde à le droit de se tromper...")
                    this.$router.push({name : 'postit'})
                }
            });
        }
    }
}

</script>


<template>
    <h1>Une pensée...</h1>
    <div class="cloud">
        <div class="post">
            <div class="postit_card">
                <h2 contenteditable class="title_cloud">{{ $route.params.title }}</h2>
                <p contenteditable class="content_cloud">{{ $route.params.content }}</p>
                <!-- <span class="white-text"></span> -->
            </div>
            <!-- <div class="road">
                <RouterLink class="open" to = "/BigPostView">Open Cloud</RouterLink>
            </div> -->
        </div>
        <img
            @click="editCloud()"
            src= "@/assets/cloud-computing-svgrepo-com.svg"
            class="img_edit"
        />
        <img
            @click="deleteCloud()"
            src= "@/assets/storm-svgrepo-com.svg"
            class="img"
        />
        
    </div>
    <div>
        <RouterLink class="rout" to = "/">Back to thoughts...</RouterLink>
    </div>
</template>










<style scoped>

.img_edit{
    margin-left: 420px;
    width: 40px;
    height: 40px;
}
.img{
    margin-left: 0px;
    width: 45px;
    height: 45px;
}

h1{
    text-transform: uppercase;
    font-size: 45px;
    font-weight: 300;
    width: fit-content;
    color: cadetblue;
}
.post {
    padding: 30px;
    padding-bottom: 0px;
}
.rout {
    color: palevioletred;
    margin-left: -150px;
}
.title_cloud{
    right: 140px;
    top: 40px;

    font-family: 'Roboto';
    display: inline-block;
    text-transform: uppercase;
    background-color: hsl(309, 100%, 89%);
    border-radius: 15px;
    border: 4px double #cccccc;
    color: #bf6fbf;
    text-align: center;
    outline: none;
    font-size: 15px;
    font-weight: 500;
    padding: 3px;
    min-width: 150px;
    width: fit-content;
    transition: all 0.5s;
    margin-top: 10px;
    margin-bottom: 20px;
    box-shadow: rgb(85, 91, 255) 0px 0px 0px 3px, rgb(31, 193, 27) 0px 0px 0px 6px, rgb(255, 217, 19) 0px 0px 0px 9px, rgb(255, 156, 85) 0px 0px 0px 12px, rgb(255, 85, 85) 0px 0px 0px 15px;
    }
.postit_card .content_cloud{


    line-height: 0;
    text-align: center;
    border: none;
    resize: none;
    font-size: 20px;
    box-sizing: border-box;
    width     : 230px;
    height    : 230px;
    padding   : 80px 1em 0 1em;
    line-height: 15px;
    outline: none;
    
    margin    : 0 100px;
    margin-top: 50px;

    position: relative;
    color:rgb(108, 87, 129, 0.7);

    background-color: #aeebff;


    border-radius: 100% 100% 0 0;
    }

    .postit_card::before,
    .postit_card::after{
    
    content: '';

    position: absolute;
    bottom  : 0px;

    
    z-index : -1;

    background-color: #aeebff;
    border-radius: 100%;
    }

    .postit_card::before{
    
    width  : 170px;
    height : 170px;

    
    left    : -20px;

    border-bottom-right-radius: 0;
    }

    .postit_card::after{
    
    width  : 135px;
    height : 135px;

    
    right   : 25px;

   
    border-bottom-left-radius: 0;
    }
    
</style>