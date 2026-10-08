<script setup>
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';

import InputError from '@/Components/InputError.vue'

defineProps({
    form: Object,
    errors: Object
});
</script>
<template>
    <div class="container-fluid">
        <div class="row pb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nome</label>
                <InputText 
                    id="name" 
                    v-model="form.name" 
                    class="w-100"
                    :class="{'is-invalid': errors.name}"
                />

                <InputError :message="errors.name" />
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Indirizzo</label>
                <InputText 
                    id="address" 
                    v-model="form.address" 
                    class="w-100"
                    :class="{'is-invalid': errors.address}"
                />

                <InputError :message="errors.address" />
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <InputText 
                    id="email" 
                    v-model="form.email" 
                    class="w-100"
                    :class="{'is-invalid': errors.email}"
                />

                <InputError :message="errors.email" />
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Telefono</label>
                <InputText 
                    id="phone" 
                    v-model="form.phone" 
                    class="w-100"
                    :class="{'is-invalid': errors.phone}"
                />

                <InputError :message="errors.phone" />
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-md-12">
                <label for="notes" class="form-label">Note</label>
                <Textarea 
                    id="notes" 
                    v-model="form.notes" 
                    class="w-100"
                    :class="{'is-invalid': errors.notes}"
                />
    
                <InputError :message="errors.notes" />
            </div>
        </div>
    </div>
</template>
<style scoped>
    
</style>