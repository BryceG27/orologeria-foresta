<script setup>
const props = defineProps({
    errors : Object
})
</script>
<template>
    <div
        v-if="Object.keys(errors).length" 
        class="alert alert-warning alert-dismissible" 
        role="alert"
    >
        <h3 class="alert-heading h4 my-2">Attenzione</h3>
        <p v-for="error in errors" class="mb-0" v-text="error" />
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</template>