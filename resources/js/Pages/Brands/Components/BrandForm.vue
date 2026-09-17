<script setup>
import InputText from 'primevue/inputtext';
import InputError from '@/Components/InputError.vue';

const emits = defineEmits(['submit']);
const props = defineProps({
    form: Object,
    errors: Object
});
</script>
<template>
    <form @submit.prevent="$emit('submit')" class="row pb-3">
        <div class="col-md-6">
            <label for="" class="form-label">Nome</label>
            <InputText 
                id="name" 
                class="form-control" 
                v-model="form.name"
            />
            <InputError :message="errors.name" />
        </div>
        <div class="col-md-6">
            <label for="" class="form-label">Immagine</label>
            <input 
                type="file" 
                id="img_path" 
                class="form-control" 
                @change="e => form.img_path = e.target.files[0]"
            />
            <img v-if="form.img_path" :src="URL.createObjectURL(form.img_path)" alt="Preview" class="img-fluid mt-2" />
            <InputError :message="errors.img_path" />
        </div>
    </form>
</template>
<style scoped>
    
</style>