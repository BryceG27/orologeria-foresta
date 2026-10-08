<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import InputText from 'primevue/inputtext';
import DatePicker from 'primevue/datepicker';
import Select from 'primevue/select';
import MultiSelect from 'primevue/multiselect';
import ContextMenu from 'primevue/contextmenu';
import Toast from 'primevue/toast';

import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';

import moment from 'moment';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const toast = useToast();

const selected_document = ref(null);
const cm = ref(null);

const menuModel = ref([
    {
        label: 'Modifica',
        icon: 'fa fa-pen text-primary',
        class: 'p-2',
        action : 'view',
    },
    {
        label: 'Stampa',
        icon: 'fa fa-print text-info',
        class: 'p-2',
        action : 'print',
    },
    {
        separator: true,
    },
    {
        label: 'Cancella',
        icon: 'fa fa-trash text-danger',
        class: 'p-2',
        action : 'delete',
        command: () => {
            deleteDocument(selected_document.value);
        }
    }
]);

defineProps({
    documents : Array
})

const filters = ref({
    'status.id' : { value: null, matchMode: FilterMatchMode.IN }
});

const onRowContextMenu = (event) => {
    cm.value.show(event.originalEvent);
};

const onCellEditComplete = (event) => {
    let { data, newData, field } = event;

    if(JSON.stringify(data) === JSON.stringify(newData))
        return;

    const form = useForm({...newData})

    form.patch(route('transport-documents.update', { document: data.id }), {
        onSuccess: () => {
            toast.add({severity:'success', summary: 'Successo', detail: 'DDT aggiornato con successo', life: 3000});
        }
    })
}

const deleteDocument = (document) => {
    const form = useForm({});

    Swal.fire({
        title: 'Sei sicuro?',
        text: "Non potrai recuperare questo DDT!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sì, cancella!',
        cancelButtonText: 'Annulla'
    }).then((result) => {
        if (result.isConfirmed) {
            /* form.delete(route('documents.destroy', { document: document.id }), {
                onSuccess: () => {
                    toast.add({severity:'success', summary: 'Successo', detail: 'DDT cancellato con successo', life: 3000});
                },
                onError: () => {
                    toast.add({severity:'error', summary: 'Errore', detail: 'Errore durante la cancellazione del DDT', life: 3000});
                }
            }); */
        }
    });
}
</script>
<template>
    <Head title="DDT" />

    <Toast />

    <AuthenticatedLayout>
        <BaseBlock title="DDT" class="m-2">
            <template #options>
                <Link
                    :href="route('transport-documents.create')"
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
                        :href="route('transport-documents.edit', selected_document?.id)"
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
                :value="documents"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                v-model:filters="filters"
                v-model:contextMenuSelection="selected_document"
                @rowContextmenu="onRowContextMenu"
            >
                <template #empty>
                    <NoItemsFound message="Nessun DDT trovato" icon="fa fa-inbox" />
                </template>

                <Column field="id" header="ID" />
                <Column field="workshop.name" header="Officina"></Column>
                <Column header="Lavorazioni">
                    <template #body="{ data }">
                        <ul>
                            <li v-for="work in data.workings" :key="work.id">{{ work.name }}</li>
                        </ul>
                    </template>
                </Column>
                <Column field="date" header="Data di creazione">
                    <template #body="{ data }">
                        {{ moment(data.date).format('DD/MM/YYYY') }}
                    </template>
                </Column>
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    
</style>