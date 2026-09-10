<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { ref, nextTick } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import Popover from 'primevue/popover';
import Chip from 'primevue/chip';
import ContextMenu from 'primevue/contextmenu';

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Swal from 'sweetalert2';

const toast = useToast();

const props = defineProps({
    customers : Array
})

const filters = ref({
    'global' : { value : null, matchMode : 'contains' }
})

const op = ref(null);
const selected_customer = ref(null);
const cm = ref(null);
const menuModel = ref([
    {
        label: 'Modifica',
        icon: 'fa fa-pen text-info',
        action : 'edit',
        class: 'p-2'
    },
    {
        separator: true,
    },
    {
        label: 'Cancella',
        icon: 'fa fa-trash text-danger',
        action : 'delete',
        class: 'p-2',
        command: () => {
            deleteCustomer(selected_customer.value);
        }
    }
]);

const deleteCustomer = (customer) => {
    Swal.fire({
        title: 'Sei sicuro?',
        text: "Non potrai tornare indietro!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, elimina!',
        cancelButtonText: 'Annulla'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm();
            form.delete(route('customers.destroy', customer.id), {
                onSuccess : () => {
                    toast.add({ severity: 'success', summary: 'Successo', detail: 'Cliente eliminato con successo.', life: 3000 });
                },
                onError : () => {
                    toast.add({ severity: 'error', summary: 'Errore', detail: 'Si è verificato un errore durante l\'eliminazione del cliente.', life: 3000 });
                }
            });
        }
    })
}

const onRowContextMenu = (event) => {
    cm.value.show(event.originalEvent);
}

</script>
<template>
    <Head title="Clienti" />

    <Toast />

    <AuthenticatedLayout>
        <BaseBlock title="Clienti" class="m-2">
            <template #options>
                <Link
                    :href="route('customers.create')"
                    class="btn btn-sm btn-primary"
                >
                    <i class="fa fa-plus me-1"></i>
                    Crea
                </Link>
            </template>

            <Popover ref="op">
                <Link
                    :href="route('customers.edit', selected_customer?.id)"
                    class="d-flex align-items-center gap-2"
                    style="width: 8rem"
                >
                    <button class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-pen"></i>
                    </button>
                    <span class="text-muted">Modifica</span>
                </Link>
                <hr />
                <div
                    class="d-flex align-items-center gap-2"
                    style="width: 8rem; cursor: pointer;"
                    @click="deleteCustomer(selected_customer)"
                >
                    <button class="btn btn-sm btn-alt-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                    <span class="text-muted">Cancella</span>
                </div>
            </Popover>

            <ContextMenu ref="cm" :model="menuModel">
                <template #item="{ item }">
                    <Link 
                        v-if="item.action === 'edit'"
                        class="link-dark p-2"
                        :href="route('customers.edit', selected_customer?.id)"
                    >
                        <i class="fa fa-pen me-2 link-info"></i>
                        Modifica
                    </Link>

                    <button class="btn btn-link link-dark p-2" type="button" v-else>
                        <i class="fa fa-trash me-2 link-danger"></i>
                        Cancella
                    </button>
                </template>
            </ContextMenu>

            <DataTable
                :value="customers"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                v-model:filters="filters"
                v-model:contextMenuSelection="selected_customer"
                @rowContextmenu="onRowContextMenu"
            >
                <template #empty>
                    <NoItemsFound message="Nessun cliente trovato" icon="fa fa-users-slash" />
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

                <Column header="Nome" style="min-width: 20rem">
                    <template #body="{ data }">
                        <Link
                            :href="route('customers.edit', { customer : data.id })"
                        >
                            <div class="d-flex justify-content-between align-items-center" v-if="data.is_company">
                                {{ data.company_name }}
                                <Chip label="Gioielleria" class="me-2" />
                            </div>
                            <span v-else>
                                {{ data.name }} {{ data.surname }}
                            </span>
                        </Link>
                    </template>
                </Column>
                <Column header="Email" field="email" />
                <Column header="Telefono" field="phone" />
                <Column header="Note" field="notes" />
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>