<script setup>
const props = defineProps({
    message : {
        type : String,
        default : "Nessun elemento trovato"
    },
    icon : {
        type : String,
        default : "fa fa-inbox"
    },
    showIcon : {
        type : Boolean,
        default : true
    }
})
</script>
<template>
    <div class="text-center p-5">
        <i v-if="showIcon" :class="icon" class="fa-3x mb-3 text-muted" />
        <div class="fw-semibold fs-5 text-muted" v-text="message" />
    </div>
</template>