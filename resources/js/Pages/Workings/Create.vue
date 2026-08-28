<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import WorkingForm from './Components/WorkingForm.vue';

const props = defineProps({
    brands : Array,
    customers : Array,
    errors : Object,
    working : Object,
})

const form = useForm({
    customer_id: null,
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
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>