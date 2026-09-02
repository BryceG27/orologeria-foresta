<script setup>
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import DatePicker from 'primevue/datepicker';
import Divider from 'primevue/divider';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';

import InputError from '@/Components/InputError.vue';

const props = defineProps({
    current_customer_is_company: Boolean,
    brands: Array,
    working_statuses: Array,
    payment_methods: Array,
    errors: Object,
    working: Object
})

</script>
<template>
    <div class="row pb-3" v-if="current_customer_is_company">
        <div class="col-md-6">
            <label for="name" class="form-label">Nome Cliente</label>
            <InputText 
                class="w-100"
                v-model="working.customer.name"
                id="name"
            />
            <!-- <InputError :message="errors.customer?.name" /> -->
        </div>
        <div class="col-md-6">
            <label for="surname" class="form-label">Cognome Cliente</label>
            <InputText 
                class="w-100"
                v-model="working.customer.surname"
                id="surname"
            />
            <!-- <InputError :message="errors.customer?.surname" /> -->
        </div>
    </div>
    <div class="row pb-3">
        <div class="col-md-6">
            <label for="brand_id" class="form-label">Marchio</label>
            <Select 
                class="w-100"
                v-model="working.brand_id"
                :options="brands"
                option-label="name"
                option-value="id"
                id="brand_id"
                filter
                filter-placeholder="Cerca marchio"
                show-clear
            />
            <InputError :message="errors?.brand_id" />
        </div>
        <div class="col-md-6">
            <label for="reference" class="form-label">Riferimento</label>
            <InputText 
                class="w-100"
                v-model="working.reference"
                id="reference"
            />
            <!-- <InputError :message="errors.reference" /> -->
        </div>
    </div>

    <div class="row pb-3">
        <div class="col-md-6">
            <label for="working_description" class="form-label">Descrizione lavorazione</label>
            <Textarea 
                class="w-100"
                v-model="working.working_description"
                id="working_description"
                :rows="3"
            />
            <!-- <InputError :message="errors.working_description" /> -->
        </div>
        <div class="col-md-6">
            <label for="extra_notes" class="form-label">Note supplementari</label>
            <Textarea 
                class="w-100"
                v-model="working.extra_notes"
                id="extra_notes"
                :rows="3"
            />
            <!-- <InputError :message="errors.extra_notes" /> -->
        </div>
    </div>

    <Divider />

    <div class="row pb-3">
        <div class="col-md-4">
            <label for="" class="form-label">Numero lavorazione</label>
            <InputText 
                class="w-100 text-end"
                v-model="working.working_id"
                id="working_id"
            />
            <!-- <InputError :message="errors.working_id" /> -->
        </div>
        <div class="col-md-4">
            <label for="" class="form-label">Data di accettazione</label>
            <DatePicker
                class="w-100"
                v-model="working.acceptance_date"
                id="acceptance_date"
            />
            <!-- <InputError :message="errors.acceptance_date" /> -->
        </div>
        <div class="col-md-4">
            <label for="" class="form-label">Stato lavorazione</label>
            <Select 
                class="w-100"
                v-model="working.working_status_id"
                :options="working_statuses"
                option-label="name"
                option-value="id"
                id="working_status"
            />
            <!-- <InputError :message="errors.working_status_id" /> -->
        </div>
    </div>

    <div class="row pb-3">
        <div class="col-md-4">
            <label for="payment_method_id" class="form-label">Metodo di pagamento</label>
            <Select 
                class="w-100"
                v-model="working.payment_method_id"
                :options="payment_methods"
                option-label="name"
                option-value="id"
                id="payment_method_id"
                filter
                filter-placeholder="Cerca metodo di pagamento"
                show-clear
            />
            <!-- <InputError :message="errors.payment_method_id" /> -->
        </div>

        <div class="col-md-4">
            <label for="" class="form-label">Data di consegna</label>
            <DatePicker
                class="w-100"
                v-model="working.delivery_date"
                id="delivery_date"
            />
            <!-- <InputError :message="errors.acceptance_date" /> -->
        </div>

        <div class="col-md-4">
            <label for="total_cost" class="form-label">Importo totale</label>
            <InputNumber
                class="w-100"
                inputClass="text-end"
                v-model="working.total_cost"
                :min="0"
                :mode="'currency'"
                currency="EUR"
                id="total_cost"
            />
            <!-- <InputError :message="errors.total_cost" /> -->
        </div>
    </div>
</template>
<style scoped>
    
</style>