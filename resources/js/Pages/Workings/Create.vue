<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import WorkingForm from './Components/WorkingForm.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import { computed, onMounted, watch } from "vue";

const props = defineProps({
    brands : Array,
    customers : Array,
    errors : Object,
    working : Object,
    working_statuses : Array,
    payment_methods : Array,
});

const form = useForm({
    customer_id: null,
    customer : {
        name: null,
        surname: null,
        company_name: null,
        is_company: false,
        custom_working_id: null,
        email: null,
        phone: null,
    },
    workings : []
});

const newWorking = () => ({
    customer_id: null,
    company_id : null,
    customer : {
        name: null,
        surname: null,
        email: null,
        phone: null
    },
    working_id: null,
    working_status_id: null,
    brand_id: null,
    reference: '',
    acceptance_date: null,
    delivery_date: null,
    working_description: '',
    extra_notes: '',
    payment_method_id: null,
    total_cost: 0.0
});

onMounted(() => {
    form.workings.push(newWorking());
    
    form.workings[0].working_id = props.working.working_id;
    form.workings[0].working_status_id = 1; //Open
})

watch(form, (value) => {
    if(value.customer_id === null) 
        return;
    
    const customer = props.customers.find(c => c.id === value.customer_id);

    if(customer.is_company) {
        form.workings.map(working => {
            working.company_id = customer.company_id;

            // Set the custom working ID for the new working if the customer has one
            // To be checked if the custom_working_id can be safely incremented
            if(customer.custom_working_id)
                working.custom_working_id = customer.last_working_id + 1;
            return working;
        });
    }
}, { deep: true, immediate: true })

const current_customer_is_company = computed(() => {
    return Boolean(props.customers.find(customer => customer.id === form.customer_id)?.is_company ?? false);
});

const add_working = () => {
    form.workings.push(newWorking());

    // Generate the new working ID based on the previous one
    form.workings[form.workings.length - 1].working_id = form.workings[form.workings.length - 2]?.working_id + 1 ?? props.working.working_id;
    form.workings[form.workings.length - 1].working_status_id = 1; //Open
}

const submit = () => {
    form.post(route('workings.store'));
}

</script>
<template>
    <Head title="Nuova lavorazione" />

    <AuthenticatedLayout>
        <BaseBlock title="Nuova lavorazione" class="m-2">
            <template #options>
                <div class="d-flex justify-content-end gap-2">
                    <button 
                        class="btn btn-sm btn-alt-primary"
                        type="button"
                        @click="add_working()"
                        v-show="current_customer_is_company"
                    >
                        <i class="fa fa-plus me-1"></i>
                        Aggiungi lavorazione
                    </button>
                    <button 
                        class="btn btn-sm btn-alt-success" 
                        v-if="!form.processing"
                        @click="submit()"
                    >
                        <i class="fa fa-save me-1"></i>
                        Salva
                    </button>
                    <ProcessingButton v-else />
                    <Link 
                        class="btn btn-sm btn-alt-danger"
                        :href="route('workings.index')"
                    >
                        <i class="fa fa-times me-1"></i>
                        Annulla
                    </Link>
                </div>
            </template>

            <WorkingForm
                :current_customer_is_company="current_customer_is_company"
                :brands="brands"
                :customers="customers"
                :errors="errors"
                :form="form"
                :payment_methods="payment_methods"
                :working_statuses="working_statuses"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
