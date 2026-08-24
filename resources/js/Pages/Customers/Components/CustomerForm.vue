<script setup>
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox';

import { ref } from 'vue';

const props = defineProps({
    form: Object,
    errors: Object,
});

</script>
<template>
    <div class="container-fluid">
        <div class="row">
            <template v-if="!form.is_company">
                <div class="col-md-4">
                    <label for="name" class="form-label">Nome</label>
                </div>
                <div class="col-md-4">
                    <label for="surname" class="form-label">Cognome</label>
                </div>
            </template>
            <template v-else>
                <div class="col-md-4">
                    <label for="company_name" class="form-label">Nome Azienda</label>
                </div>
                <div class="col-md-4">
                    <label for="working_custom_id" class="form-label">Numero lavorazione custom</label>
                </div>
            </template>
            <div class="col-md-4 text-center">
                <label for="is_company" class="form-label">E' una gioielleria?</label>
            </div>
        </div>
        <div class="row align-items-center pb-3">
            <template v-if="!form.is_company">
                <div class="col-md-4">
                    <InputText 
                        class="w-100"
                        id="name"
                        v-model="form.name"
                    />
                </div>
                <div class="col-md-4">
                    <InputText 
                        class="w-100"
                        id="surname"
                        v-model="form.surname"
                    />
                </div>
            </template>
            <template v-else>
                <div class="col-md-4">
                    <InputText 
                        class="w-100"
                        id="company_name"
                        v-model="form.company_name"
                    />
                </div>
                <div class="col-md-4">
                    <InputText 
                        class="w-100"
                        id="working_company_id"
                        v-model="form.working_company_id"
                    />
                </div>
            </template>
            <div class="col-md-4 d-flex flex-row justify-content-center align-items-center gap-2">
                <Checkbox 
                    input-id="is_company"
                    v-model="form.is_company"
                    binary
                />
            </div>
        </div>
        <div class="row pb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <InputText 
                    class="w-100"
                    id="email"
                    v-model="form.email"
                />
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Cellulare</label>
                <InputText 
                    class="w-100"
                    id="phone"
                    v-model="form.phone"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
    </div>
</template>