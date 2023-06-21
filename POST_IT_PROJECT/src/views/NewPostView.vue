<script>
export default {

    data() {
      return {
        title: "",
        content:"",
      };
    },
    methods: {
        AddCloudIt(){ 
            fetch('http://5.135.119.239:3090/notes/', {
                method: 'POST',
                headers: {"Content-Type": "application/json",
                },
                body: JSON.stringify({"title": this.title, "content": [this.content]
                })
                }).then(response => {
                    if(response.ok == true){
                        this.$toast.success("La mémoire est une sorte d'identité...")
                        this.$router.push({name : 'postit'});
                    }
                });
        }
    },
};

</script>   

<template>
    <h1>Nouvelle pensée...</h1>
    <div class="cloud">
        <div class="post">
            <!-- <p>The title is: {{ title }}</p> -->
            <input 
            v-model="title" 
            placeholder="Le nom de cette pensée..." 
            />
                <div class="postit_card">
                    <!-- <p>The message is marked here : {{ content }}</p> -->
                    <textarea 
                    v-model="content" name="textarea" 
                    rows="5" cols="30" minlength="5" maxlength="250"
                    style="overflow: hidden" 
                    placeholder ="La pensée une fois écrite est concrête...">
                    </textarea>
                    <!-- <span class="white-text"></span> -->
                </div>
        </div>
  </div>
  <div>
    <RouterLink class="rout" to = "/">Back to thoughts...</RouterLink>
  </div>
  <button class="save" @click="AddCloudIt()">Save your Thought</button> 

</template>
















<style scoped>
input{
    right: 100px;
    top: 25px;

    font-family: 'Roboto';
    font-size: 15px;
    font-weight: 400;

    color: rgb(75, 102, 103);
    border: none;
    outline: none;
    background-color: #b4e3ff;
    border-radius: 15px;
    margin-left: -60px;
    margin-top: 15px;
    margin-bottom: 15px;
    padding: 10px;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    box-shadow: rgb(85, 91, 255) 0px 0px 0px 3px, rgb(31, 193, 27) 0px 0px 0px 6px, rgb(255, 217, 19) 0px 0px 0px 9px, rgb(255, 156, 85) 0px 0px 0px 12px, rgb(255, 85, 85) 0px 0px 0px 15px;

}
p{
    color: black;
}
h1{
    font-family: 'Roboto';
    text-transform: uppercase;
    font-size: 45px;
    font-weight: 300;
    width: fit-content;
    color: cadetblue;
}
textarea{
    font-family: 'Roboto';
    font-weight: 400;
    color:#b98562;
    line-height: 30px;
    outline: none;
    padding-bottom: 10px;
}
.save{
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
    width: 150px;
    transition: all 0.5s;
    margin-top: 10px;
    margin-bottom: 20px;
    margin-left: 350px;
    cursor: pointer;
    box-shadow: rgb(85, 91, 255) 0px 0px 0px 3px, rgb(31, 193, 27) 0px 0px 0px 6px, rgb(255, 217, 19) 0px 0px 0px 9px, rgb(255, 156, 85) 0px 0px 0px 12px, rgb(255, 85, 85) 0px 0px 0px 15px;
}

.post {
    padding: 30px;
}
.rout {
    color: palevioletred;
}
.postit_card textarea{

line-height: 15px;
text-align: center;
border: none;
resize: none;
box-sizing: border-box;
width     : 230px;
height    : 230px;
padding   : 130px 1em 0 1em;
padding-bottom: 10px;
margin    : 0 100px;

position: relative;

background-color: #aeebff;


border-radius: 100% 100% 0 0;
}

.postit_card::before,
.postit_card::after{

content: '';

position: absolute;
bottom  : 3px;


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