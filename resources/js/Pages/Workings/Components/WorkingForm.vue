<script setup>
import InputText from 'primevue/inputtext';
import AutoComplete from 'primevue/autocomplete';
import Select from 'primevue/select';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import Button from 'primevue/button';

import InputError from '@/Components/InputError.vue';
import { ref } from "vue";
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    brands: Array,
    customers: Array,
    form: Object,
    errors: Object,
    payment_methods: Array,
})

const customersFilter = ref([]);

const search = (event) => {
    customersFilter.value = event.query ? props.customers.filter(customer => customer.name.toLowerCase().includes(event.query.toLowerCase())) : props.customers;
}

const new_customer = () => {

}

const customer_form = useForm({
    name: null,
    surname: null,
    company_name: null,
    email: null,
    phone: null
});

const store_customer = () => {
    customer_form.post(route('customers.store'))
}

</script>
<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <label for="customer_id" class="form-label">Cliente</label>

                <InputGroup>
                    <InputGroupAddon>
                        <Button icon="fa fa-plus" />
                    </InputGroupAddon>
                    <AutoComplete 
                        inputId="customer_id"
                        v-model="form.customer_id" 
                        dropdown 
                        :suggestions="customersFilter" 
                        optionLabel="description"
                        optionValue="id"
                        @complete="search"
                        @blur="new_customer()"
                        class="w-100"
                    />
                </InputGroup>
                <!-- <InputError :message="errors." /> -->
            </div>
            <div class="col-md-4">
                <!-- <InputError :message="errors." /> -->
            </div>
            <div class="col-md-4">
                <!-- <InputError :message="errors." /> -->
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">

        </div>
    </div>
</template>
<style scoped>
    
</style>