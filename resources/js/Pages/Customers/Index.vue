<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { ref } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';

const props = defineProps({
    customers : Array
})

const filters = ref({
    'global' : { value : null, matchMode : 'contains' }
})

</script>
<template>
    <Head title="Clienti" />

    <AuthenticatedLayout>
        <BaseBlock title="Clienti" class="m-2">
            <template #options>
                <Link
                    :href="route('customers.create')"
                    class="btn btn-sm btn-primary"
                >
                    <i class="fa fa-plus me-1"></i>
                    Nuovo
                </Link>
            </template>

            <DataTable
                :value="customers"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                v-model:filters="filters"
            >
                <template #empty>
                    <NoItemsFound message="Nessun cliente trovato" />
                </template>

                <template #header>
                    <div class="d-flex justify-content-end">
                        <IconField>
                            <InputIcon>
                                <i class="fa fa-search" />
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Cerca cliente" />
                        </IconField>
                    </div>
                </template>

                <Column header="Nome">
                    <template #body="{ data }">
                        <span v-if="data.is_company" v-text="data.company_name" />
                        <span v-else v-text="data.name + ' ' + data.surname" />
                    </template>
                </Column>
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>