<script setup>
const props = defineProps({
    class: {
        type: String,
        default: 'btn-alt-success'
    }
})
</script>
<template>
    <button class="btn btn-sm" :class="class" type="button" disabled>
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
    </button>
</template>