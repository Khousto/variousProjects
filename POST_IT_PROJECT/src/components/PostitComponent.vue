<script>
export default {
 
}
</script>

<template>

    <div class="cloud">
        <div class="post">
            <div class="postit_card">
                <textarea name="textarea" rows="5" cols="30" minlength="5" maxlength="135" style="overflow: hidden" placeholder="Ne pas oublier..."></textarea>
                <!-- <span class="white-text"></span> -->
            </div>
        </div>
  </div>
  <div>
    <RouterLink class="open" to = "/BigPostView">Open Cloud</RouterLink>
  </div>

</template>
















<style scoped>
.post {
    padding: 30px;
}
.open {
    color: chocolate;
}
.postit_card textarea{

line-height: 0;
text-align: center;
border: none;
resize: none;
box-sizing: border-box;
width     : 250px;
height    : 250px;
padding   : 150px 1em 0 1em;

margin    : 0 100px;

position: relative;

background-color: #ffb07b;


border-radius: 100% 100% 0 0;
}

.postit_card::before,
.postit_card::after{

content: '';

position: absolute;
bottom  : 3px;


z-index : -1;

background-color: #ffb07b;
border-radius: 100%;
}

.postit_card::before{

width  : 215px;
height : 215px;


left    : -80px;

border-bottom-right-radius: 0;
}

.postit_card::after{

width  : 180px;
height : 180px;


right   : -60px;


border-bottom-left-radius: 0;
}

</style>