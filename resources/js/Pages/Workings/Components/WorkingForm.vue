<script setup>
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import FieldSet from 'primevue/fieldset';

import WorkingCard from './WorkingCard.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from "vue";

const props = defineProps({
    current_customer_is_company : Boolean,
    brands: Array,
    customers: Array,
    errors: Object,
    form : Object,
    payment_methods: Array,
    working_statuses: Array,
})

const store_customer = ref(false);

</script>
<template>
    <div class="container-fluid">
        <div class="row pb-3" v-if="!store_customer">
            <div class="col-md-6">
                <label for="customer_id" class="form-label">Cliente</label>
                <InputGroup>
                    <button class="btn btn-alt-success" type="button" @click="store_customer = true">
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
                        empty-filter-message="Nessun cliente trovato"
                        filter
                    />
                </InputGroup>
                <InputError :message="errors.customer_id" />
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

        <div 
            class="pb-3"
            v-for="(working, index) in form.workings"
            :key="index"
        >
            <FieldSet
                :toggleable="current_customer_is_company && form.workings.length > 1" 
                :collapsed="index + 1 != form.workings.length"
                :legend="current_customer_is_company ? (working.customer.surname ?? `Lavorazione #${index + 1}`) : undefined"
            >
                <WorkingCard 
                    :current_customer_is_company="current_customer_is_company"
                    :working="working"
                    :brands="brands"
                    :errors="errors.workings?.[index]"
                    :working_statuses="working_statuses"
                    :payment_methods="payment_methods"
                />
            </FieldSet>
        </div>
    </div>

</template>
