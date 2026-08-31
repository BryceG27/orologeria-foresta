<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

import WorkingForm from './Components/WorkingForm.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';

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
    working_id: props.working.working_id,
    working_status_id: props.working.working_status_id,
    brand_id: null,
    reference: '',
    delivery_date: null,
    working_description: '',
    extra_notes: '',
    payment_method_id: null,
    total_cost: 0.0
});

watch(form.customer_id, (newValue) => {
    const customer = props.customers.find(c => c.id === newValue);

    if(customer.is_company) {
        form.working_id = customer.last_custom_working_id;
    }
});

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
                :brands="brands"
                :customers="customers"
                :form="form"
                :errors="errors"
                :payment_methods="payment_methods"
                :working_statuses="working_statuses"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>