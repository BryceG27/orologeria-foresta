<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import CustomerForm from './Components/CustomerForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customer: Object,
    errors: Object
});

const form = useForm({
    name: props.customer.name,
    surname: props.customer.surname,
    company_name: props.customer.company_name,
    working_company_id: props.customer.working_company_id,
    email: props.customer.email,
    phone: props.customer.phone,
    notes: props.customer.notes,
    is_company: props.customer.is_company,
});

const submit = () => {
    form.patch(route('customers.edit', { customer: props.customer.id }), {
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>
<template>
    <Head title="Aggiorna cliente" />
    
    <AuthenticatedLayout>
        <BaseBlock title="Aggiorna cliente" class="m-2">
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
                        :href="route('customers.index')"
                    >
                        <i class="fa fa-times me-1"></i>
                        Annulla
                    </Link>
                </div>
            </template>

            <CustomerForm 
                :form="form" 
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    .justify-content-end .btn {
        min-width: 5rem
    }
</style>