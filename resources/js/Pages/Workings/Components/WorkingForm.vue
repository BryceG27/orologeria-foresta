<script setup>
import InputText from 'primevue/inputtext';
import AutoComplete from 'primevue/autocomplete';
import Select from 'primevue/select';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import DatePicker from 'primevue/datepicker';

import InputError from '@/Components/InputError.vue';
import { ref } from "vue";

const props = defineProps({
    brands: Array,
    customers: Array,
    form: Object,
    customer_form: Object,
    errors: Object,
    payment_methods: Array,
    working_statuses: Array,
})

const customersFilter = ref([]);

const search = (event) => {
    customersFilter.value = event.query ? props.customers.filter(customer => {
        return customer.description?.toLowerCase().includes(event.query?.toLowerCase());
    }) : props.customers;
}


const store_customer = ref(false);

const enable_customer_form = () => {
    console.log(props.form.customer_id);
    
    /* if(props.form.customer_id) 
        return;

    if(props.form.customer_id.split(' ').length > 1) {
        props.form.customer.name = props.form.customer_id.split(' ')[0];
        props.form.customer.surname = props.form.customer_id.split(' ')[1];
    } else {
        props.form.customer.name = props.form.customer_id;
    }

    props.form.customer_id = null;
    
    store_customer.value = true; */
}

</script>
<template>
    <div class="container-fluid">
        <div class="row" v-if="!store_customer">
            <div class="col-md-6">
                <label for="customer_id" class="form-label">Cliente</label>
                <InputGroup>
                    <InputGroupAddon>
                        <Button icon="fa fa-plus" @click="store_customer = true" />
                    </InputGroupAddon>
                    <Select 
                        inputId="customer_id"
                        v-model="form.customer_id" 
                        :options="customers" 
                        optionLabel="description"
                        optionValue="id"
                        class="w-100"
                        showClear
                        empty-filter-message="Nessun cliente trovato"
                        filter
                    />
                </InputGroup>
                <!-- <InputError :message="errors." /> -->
            </div>
        </div>

        <template v-else>
            <div class="row">
                <div class="col-md-3">
                    <h5 class="pb-0">Anagrafica cliente</h5>
                </div>
            </div>
            <div class="row align-items-start pb-3">
                <template v-if="!form.customer.is_company">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Nome</label>
                        <InputGroup>
                            <InputGroupAddon>
                                <Button icon="fa fa-minus" severity="danger" @click="store_customer = false" />
                            </InputGroupAddon>
                            <InputText 
                                class="w-100"
                                v-model="form.customer.name"
                                id="name"
                            />
                        </InputGroup>
                        <InputError :message="errors.customer?.name" />
                    </div>
                    <div class="col-md-4">
                        <label for="surname" class="form-label">Cognome</label>
                        <InputText 
                            class="w-100"
                            v-model="form.customer.surname"
                            id="surname"
                        />
                        <InputError :message="errors.customer?.surname" />
                    </div>
                </template>

                <template v-else>
                    <div class="col-md-4">
                        <label for="company_name" class="form-label">Nome Gioielleria</label>
                        <InputGroup>
                            <InputGroupAddon>
                                <Button icon="fa fa-minus" severity="danger" @click="store_customer = false" />
                            </InputGroupAddon>
                            <InputText 
                                class="w-100"
                                v-model="form.customer.company_name"
                                id="company_name"
                            />
                            <InputError :message="errors.customer?.company_name" />
                        </InputGroup>
                    </div>
                    <div class="col-md-4">
                        <label for="custom_working_id" class="form-label">ID lavorazione personalizzato</label>
                        <InputText 
                            class="w-100"
                            v-model="form.customer.custom_working_id"
                            id="custom_working_id"
                        />
                        <InputError :message="errors.customer?.custom_working_id" />
                    </div>
                </template>

                <div class="col-md-4 d-flex flex-column gap-2">
                    <label for="is_company" class="form-label">E' una gioielleria?</label>
                    <Checkbox 
                        input-id="is_company"
                        v-model="form.customer.is_company"
                        binary
                    />
                    <InputError :message="errors.customer?.is_company" />
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

        <hr>

        <div class="row pb-3">
            <div class="col-md-6">
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
                />
                <InputError :message="errors.brand_id" />
            </div>
            <div class="col-md-6">
                <label for="reference" class="form-label">Riferimento</label>
                <InputText 
                    class="w-100"
                    v-model="form.reference"
                    id="reference"
                />
                <InputError :message="errors.reference" />
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-md-6">
                <label for="working_description" class="form-label">Descrizione lavorazione</label>
                <Textarea 
                    class="w-100"
                    v-model="form.working_description"
                    id="working_description"
                    :rows="3"
                />
                <InputError :message="errors.working_description" />
            </div>
            <div class="col-md-6">
                <label for="extra_notes" class="form-label">Note supplementari</label>
                <Textarea 
                    class="w-100"
                    v-model="form.extra_notes"
                    id="extra_notes"
                    :rows="3"
                />
                <InputError :message="errors.extra_notes" />
            </div>
        </div>

        <hr>

        <div class="row pb-3">
            <div class="col-md-4">
                <label for="" class="form-label">Numero lavorazione</label>
                <InputText 
                    class="w-100 text-end"
                    v-model="form.working_id"
                    id="working_id"
                />
                <InputError :message="errors.working_id" />
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Data di consegna</label>
                <DatePicker
                    class="w-100"
                    v-model="form.delivery_date"
                    id="delivery_date"
                />
                <InputError :message="errors.delivery_date" />
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Stato lavorazione</label>
                <Select 
                    class="w-100"
                    v-model="form.working_status_id"
                    :options="working_statuses"
                    option-label="name"
                    option-value="id"
                    id="working_status"
                />
                <InputError :message="errors.working_status_id" />
            </div>
        </div>

        <div class="row pb-3">
            <div class="col-md-6">
                <label for="payment_method" class="form-label">Metodo di pagamento</label>
                <Select 
                    class="w-100"
                    v-model="form.payment_method"
                    :options="payment_methods"
                    option-label="name"
                    option-value="id"
                    id="payment_method"
                    filter
                    filter-placeholder="Cerca metodo di pagamento"
                    show-clear
                />
                <InputError :message="errors.payment_method" />
            </div>

            <div class="col-md-6">
                <label for="total_amount" class="form-label">Importo totale</label>
                <InputNumber
                    class="w-100"
                    inputClass="text-end"
                    v-model="form.total_amount"
                    :min="0"
                    :mode="'currency'"
                    currency="EUR"
                    id="total_amount"
                />
                <InputError :message="errors.total_amount" />
            </div>
        </div>
    </div>
</template>
<style scoped>
    
</style>