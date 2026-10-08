<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { ref } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import ContextMenu from 'primevue/contextmenu';

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Swal from 'sweetalert2';

const toast = useToast();

const props = defineProps({
    workshops : Array
})

const filters = ref({
    'global' : { value : null, matchMode : 'contains' }
})

const selected_workshop = ref(null);
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
            deleteWorkshop(selected_workshop.value);
        }
    }
]);

const deleteWorkshop = (workshop) => {
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
            form.delete(route('workshops.destroy', workshop.id), {
                onSuccess : () => {
                    toast.add({ severity: 'success', summary: 'Successo', detail: 'Officina eliminato con successo.', life: 3000 });
                },
                onError : () => {
                    toast.add({ severity: 'error', summary: 'Errore', detail: 'Si è verificato un errore durante l\'eliminazione dell\'officina.', life: 3000 });
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
    <Head title="Officine" />

    <Toast />

    <AuthenticatedLayout>
        <BaseBlock title="Officine" class="m-2">
            <template #options>
                <Link
                    :href="route('workshops.create')"
                    class="btn btn-sm btn-alt-primary"
                >
                    <i class="fa fa-plus me-1"></i>
                    Crea
                </Link>
            </template>

            <ContextMenu ref="cm" :model="menuModel">
                <template #item="{ item }">
                    <Link 
                        v-if="item.action === 'edit'"
                        class="btn btn-link link-dark"
                        :href="route('workshops.edit', selected_workshop?.id)"
                    >
                        <i class="fa fa-pen me-2 link-info"></i>
                        Modifica
                    </Link>

                    <button class="btn btn-link link-dark" type="button" v-else>
                        <i class="fa fa-trash me-2 link-danger"></i>
                        Cancella
                    </button>
                </template>
            </ContextMenu>

            <DataTable
                :value="workshops"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                v-model:filters="filters"
                v-model:contextMenuSelection="selected_workshop"
                @rowContextmenu="onRowContextMenu"
            >
                <template #empty>
                    <NoItemsFound message="Nessuna officina trovata" icon="fa fa-wrench" />
                </template>

                <template #header>
                    <div class="d-flex justify-content-end">
                        <IconField>
                            <InputIcon>
                                <i class="fa fa-search" />
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Cerca officina" />
                        </IconField>
                    </div>
                </template>

                <Column header="Nome" style="min-width: 8.5rem">
                    <template #body="{ data }">
                        <Link
                            :href="route('workshops.edit', { workshop : data.id })"
                        >
                            {{ data.name }}
                        </Link>
                    </template>
                </Column>
                <Column header="Indirizzo" field="address" />
                <Column header="Email" field="email" />
                <Column header="Telefono" field="phone" />
                <Column header="Note" field="notes" />
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    
</style>