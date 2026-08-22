<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { ref, computed } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import { FilterMatchMode } from '@primevue/core/api';

import moment from 'moment';

const props = defineProps({
    workings : Array
})

const filters = ref({
    'global' : { value : null, matchMode : FilterMatchMode.CONTAINS },
    brand : { value : null, matchMode : FilterMatchMode.IN },
    customer : { value : null, matchMode : FilterMatchMode.CONTAINS },
    status : { value : null, matchMode : FilterMatchMode.IN }
})
</script>
<template>
    <Head title="Lavorazioni" />

    <AuthenticatedLayout>
        <BaseBlock title="Lavorazioni" class="m-2">
            <template #options>
                <Link
                    :href="route('workings.create')"
                    class="btn btn-sm btn-primary"
                >
                    <i class="fa fa-plus me-1"></i>
                    Crea
                </Link>
            </template>

            <DataTable
                :value="workings"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                v-model:filters="filters"
            >
                <template #empty>
                    <NoItemsFound message="Nessuna lavorazione trovata" />
                </template>

                <template #header>
                    <div class="d-flex justify-content-end">
                        <IconField>
                            <InputIcon>
                                <i class="fa fa-search" />
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Cerca lavorazione" />
                        </IconField>
                    </div>
                </template>

                <Column header="#" field="working_id">
                    <template #body="{ data }">
                        <Link
                            :href="route('workings.edit', { working : data.id })"
                            v-text="data.working_id"
                        />
                    </template>
                </Column>

                <Column header="Cliente" field="customer_id">
                    <template #body="{ data }">
                        <Link
                            :href="route('customers.edit', { customer : data.customer.id })"
                        >
                            <span v-if="data.customer.is_company" v-text="data.customer.company_name" />
                            <span v-else>{{ data.customer.name }} {{ data.customer.surname }}</span>
                        </Link>
                    </template>
                </Column>

                <Column header="Marchio" field="brand.name" />
                <Column header="Referenza" field="reference" />
                <Column header="Consegna" field="delivery_date">
                    <template #body="{ data }">
                        {{ data.delivery_date ? moment(data.delivery_date).format('DD/MM/YYYY') : '' }}
                    </template>
                </Column>

                <Column header="Stato" field="status.name">
                    <template #body="{ data }">
                        
                    </template>
                </Column>
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>