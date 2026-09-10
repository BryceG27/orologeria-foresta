<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import CustomerForm from './Components/CustomerForm.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { DataTable, Column } from 'primevue';
import moment from 'moment';

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
    is_company: Boolean(props.customer.is_company),
});

const submit = () => {
    form.patch(route('customers.edit', { customer: props.customer.id }), {
        onSuccess: () => {
            form.reset();
        },
    });
};

const costs = computed(() => {
    if(props.customer.is_company) 
        return parseFloat(props.customer.associated_workings.reduce((sum, working) => sum + (working.total_cost ?? 0), 0)).toFixed(2);

    return parseFloat(props.customer.workings.reduce((sum, working) => sum + (working.total_cost ?? 0), 0)).toFixed(2)
})

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

        <BaseBlock :title="`Lavorazioni ${customer.is_company ? 'associate' : ''}`" class="m-2">
            <DataTable
                :value="customer.is_company ? customer.associated_workings : customer.workings"
                rowGroupMode="subheader"
            >
                <Column header="#" field="working_id" />
                <Column header="Cliente" v-if="customer.is_company">
                    <template #body="{ data }">
                        {{ data.customer.name }} {{ data.customer.surname }}
                    </template>
                </Column>
                <Column header="Marchio" field="brand.name" />
                <Column header="Referenza" field="reference" />
                <Column header="Accettazione">
                    <template #body="{ data }">
                        {{ data.acceptance_date ? moment(data.acceptance_date).format('DD/MM/YYYY') : '' }}
                    </template>
                </Column>
                <Column header="Consegna">
                    <template #body="{ data }">
                        {{ data.delivery_date ? moment(data.delivery_date).format('DD/MM/YYYY') : '' }}
                    </template>
                </Column>
                <Column header="Stato" field="status.name">
                    <template #body="{ data }">
                        <span :class="`badge rounded-pill p-2 bg-${data.status.bs_color}`">
                            {{ data.status.name }}
                        </span>
                    </template>
                </Column>
                <Column header="Costo">
                    <template #body="{ data }">
                        {{ parseFloat(data.total_cost ?? 0).toFixed(2) }} &euro;
                    </template>
                </Column>

                <template #footer>
                    <div class="d-flex justify-content-end w-full gap-2">Totale: <strong>{{ costs }} &euro;</strong></div>
                </template>
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    .justify-content-end .btn {
        min-width: 5rem
    }
</style>