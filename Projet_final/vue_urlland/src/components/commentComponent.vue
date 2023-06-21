<script setup>
    defineProps({
        id: {
            type: String,
            required: true,
        },
        content: {
            type: String,
            required: true,
        },
        nb_like: {
            type: Number,
            required: true,
        },
        id_user: {
            type: Number,
            required: true,
        },
        created_at: {
            type: Date,
            required: true,
        },
        id_post: {
            type: Number,
            required: true,
        }
    });
</script>

<template>

    <div class="comment">       
        <div class="com_content" :content="id">{{ content }}</div>
        <!-- <div class="com_nb_like">{{ nb_like }}</div>
        <div class="com_id_user">{{ id_user }}</div> -->
        <div class="com_created_at">Posté le : {{ created_at }}</div>
        <div class="com_id_post">{{ id_post }}</div>
    </div>
</template>

<style>
.comment {
    display: flex;
    flex-direction: row;
    border-radius: 24px;
    background-color: #FFFEF6;
    margin-left: 150px;
    margin-right: 150px;
    padding: 15px;
}
.com_content {
    font-family: "Roboto Condensed";
    font-size: 20px;
    color: #606c5a;
}
.com_created_at{
    text-align: center;
    font-family: 'Roboto Condensed';
    color: #606c5a;
    text-align: right;
    margin-left: 20px;
    height: 20px;
    padding-top: 10px;
}

</style>