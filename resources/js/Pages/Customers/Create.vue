<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import CustomerForm from './Components/CustomerForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    errors: Object
});

const form = useForm({
    name: null,
    surname : null,
    company_name: null,
    working_company_id : null,
    email : null,
    phone : null,
    notes : null,
    is_company : false,
});

const submit = () => {
    form.post(route('customers.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>
<template>
    <Head title="Nuovo cliente" />
    
    <AuthenticatedLayout>
        <BaseBlock title="Nuovo cliente" class="m-2">
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
                :errors="errors"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    .justify-content-end .btn {
        min-width: 5rem
    }
</style>