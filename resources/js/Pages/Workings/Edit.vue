<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import WorkingForm from './Components/WorkingForm.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import { computed, onMounted, watch } from "vue";

const props = defineProps({
    customers : Array,
    brands : Array,
    errors : Object,
    working : Object,
    working_statuses : Array,
    payment_methods : Array,
});

const form = useForm({
    id : props.working.id,
    customer_id: props.working.customer_id,
    company_id : props.working.company_id,
    working_id: props.working.working_id,
    working_status_id: props.working.working_status_id,
    brand_id: props.working.brand_id,
    reference: props.working.reference,
    acceptance_date: props.working.acceptance_date,
    delivery_date: props.working.delivery_date,
    working_description: props.working.working_description,
    extra_notes: props.working.extra_notes,
    payment_method_id: props.working.payment_method_id,
    total_cost: props.working.total_cost
});

const submit = () => {
    form.patch(route('workings.update', {
        working: props.working.id,
    }));
}

</script>
<template>
    <Head title="Modifica lavorazione" />
    <AuthenticatedLayout>
        <BaseBlock :title="`Modifica lavorazione #${props.working.working_id}`" class="m-2">
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
                :errors="errors"
                :form="form"
                :payment_methods="payment_methods"
                :working_statuses="working_statuses"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
