<script setup>
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import InputGroup from 'primevue/inputgroup';
import InputNumber from 'primevue/inputnumber';
import Textarea from 'primevue/textarea';
import DatePicker from 'primevue/datepicker';

import InputError from '@/Components/InputError.vue';
import { ref } from "vue";

const props = defineProps({
    brands : Array,
    customers : Array,
    statuses : Array,
    payment_order_statuses : Array,
    errors : Object,
    form : Object
})

const store_customer = ref(false);
</script>
<template>
    <div class="container-fluid">
        <div class="row pb-3" v-if="!store_customer">
            <div class="col-md-6">
                <label for="customer_id" class="form-label">Cliente</label>
                <InputGroup>
                    <button class="btn btn-alt-success" type="button" @click="store_customer = true" v-if="!form.id">
                        <i class="fa fa-plus"></i>
                    </button>
                    <Select 
                        inputId="customer_id"
                        v-model="form.customer_id" 
                        :options="customers" 
                        optionLabel="description"
                        optionValue="id"
                        class="w-100"
                        showClear
                        :disabled="form.id != null"
                        empty-filter-message="Nessun cliente trovato"
                        filter
                    />
                </InputGroup>
            
                <InputError :message="errors.customer_id" />
            </div>
        </div>

        <template v-else>
            <div class="row border-bottom">
                <div class="col-md-3">
                    <h5 class="pb-0">Anagrafica cliente</h5>
                </div>
            </div>
            <div class="row align-items-start py-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <InputGroup>
                        <button class="btn btn-alt-danger" @click="store_customer = false">
                            <i class="fa fa-minus"></i>
                        </button>
                        <InputText 
                            class="w-100"
                            v-model="form.customer.name"
                            id="name"
                        />
                    </InputGroup>
                    <InputError :message="errors.customer?.name" />
                </div>
                <div class="col-md-6">
                    <label for="surname" class="form-label">Cognome</label>
                    <InputText 
                        class="w-100"
                        v-model="form.customer.surname"
                        id="surname"
                    />
                    <InputError :message="errors.customer?.surname" />
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Telefono</label>
                    <InputText 
                        class="w-100"
                        v-model="form.customer.phone"
                        id="phone"
                    />
                    <InputError :message="errors.customer?.phone" />
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <InputText 
                        class="w-100"
                        v-model="form.customer.email"
                        id="email"
                    />
                    <InputError :message="errors.customer?.email" />
                </div>
            </div>
        </template>

        <div class="row pb-3">
            <div class="col-md-4">
                <label for="brand_id" class="form-label">Marchio</label>
                <Select 
                    class="w-100"
                    v-model="form.brand_id"
                    :options="brands"
                    option-label="name"
                    option-value="id"
                    id="brand_id"
                    filter
                    filter-placeholder="Cerca marchio"
                    show-clear
                    :invalid="errors?.brand_id != null"
                />
            </div>
            <div class="col-md-4">
                <label for="description" class="form-label">Prodotto ordinato</label>
                <InputText 
                    class="w-100"
                    v-model="form.description"
                    id="description"
                    :invalid="errors?.description != null"
                />
            </div>
            <div class="col-md-4">
                <label for="order_date" class="form-label">Data ordine</label>
                <DatePicker 
                    class="w-100"
                    v-model="form.order_date"
                    id="order_date"
                    date-format="dd/mm/yy"
                    :invalid="errors?.order_date != null"
                />
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-12">
                <label for="notes" class="form-label">Note aggiuntive</label>
                <Textarea
                    class="w-100"
                    v-model="form.notes"
                    id="notes"
                    rows="3"
                    :invalid="errors?.notes != null"
                />
                <InputError :message="errors?.notes" />
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-md-4">
                <label for="total" class="form-label">Totale</label>
                <InputNumber 
                    inputId="total" 
                    v-model="form.total"
                    :min="0"
                    mode="currency"
                    currency="EUR"
                    locale="it-IT"
                    class="w-100"
                    inputClass="text-end"
                />

                <InputError :message="errors?.total" />
            </div>
            <div class="col-md-4">
                <label for="payment_order_status_id" class="form-label">Stato pagamento</label>
                <Select 
                    class="w-100"
                    v-model="form.payment_order_status_id"
                    :options="payment_order_statuses"
                    option-label="name"
                    option-value="id"
                    id="payment_order_status_id"
                />
            </div>
            <div class="col-md-4">
                <label for="downpayment" class="form-label">Pagato</label>
                <InputNumber 
                    inputId="downpayment" 
                    v-model="form.downpayment"
                    :min="0"
                    :max="parseFloat(form.total)"
                    mode="currency"
                    currency="EUR"
                    locale="it-IT"
                    class="w-100"
                    inputClass="text-end"
                    :disabled="form.payment_order_status_id !== 3"
                />

                <InputError :message="errors?.downpayment" />
            </div>
        </div>
    </div>
</template>
<style scoped>
    
</style>