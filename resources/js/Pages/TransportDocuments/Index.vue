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

const selected_order = ref(null);
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
            deleteDocument(selected_order.value);
        }
    }
]);

const props = defineProps({
    transport_documents : Array
})

const filters = ref({
    'customer.description' : { value: null, matchMode: FilterMatchMode.CONTAINS },
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

    form.patch(route('orders.update', { order: data.id }), {
        onSuccess: () => {
            toast.add({severity:'success', summary: 'Successo', detail: 'Ordine aggiornato con successo', life: 3000});
        }
    })
}

const deleteDocument = (order) => {
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
            /* form.delete(route('orders.destroy', { order: order.id }), {
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
    <div>
        
    </div>
</template>
<style scoped>
    
</style>