<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import OrderForm from './Components/OrderForm.vue';

const props = defineProps({
    order : Object,
    brands : Array,
    customers : Array,
    statuses : Array,
    payment_order_statuses : Array,
    errors : Object
})

const form = useForm({
    id : props.order.id,
    brand_id : props.order.brand_id,
    description : props.order.description,
    customer_id : props.order.customer_id,
    order_date : props.order.order_date,
    downpayment : props.order.downpayment,
    total : props.order.total,
    order_status_id : props.order.order_status_id,
    payment_order_status_id : props.order.payment_order_status_id
});

const submit = () => {
    form.patch(route('orders.update', { order: form.id }));
};
</script>
<template>
    <Head title="Modifica ordine #{{ props.order.id }}" />

    <AuthenticatedLayout>
        <BaseBlock title="Nuovo ordine" class="m-2">
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
                        :href="route('orders.index')"
                    >
                        <i class="fa fa-times me-1"></i>
                        Annulla
                    </Link>
                </div>
            </template>

            <OrderForm
                :brands="brands"
                :customers="customers"
                :statuses="statuses"
                :payment_order_statuses="payment_order_statuses"
                :form="form"
                :errors="errors"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    
</style>