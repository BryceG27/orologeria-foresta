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
            deleteOrder(selected_order.value);
        }
    }
]);

const props = defineProps({
    statuses : Array,
    payment_statuses : Array,
    brands : Array,
    orders : Array
})

const filters = ref({
    'customer.description' : { value: null, matchMode: FilterMatchMode.CONTAINS },
    'brand.id' : { value: null, matchMode: FilterMatchMode.IN },
    order_date : { value: null, matchMode: FilterMatchMode.DATE_IS },
    'status.id' : { value: null, matchMode: FilterMatchMode.IN },
    'payment_status.id' : { value: null, matchMode: FilterMatchMode.IN }
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

const deleteOrder = (order) => {
    const form = useForm({});

    Swal.fire({
        title: 'Sei sicuro?',
        text: "Non potrai recuperare questo ordine!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sì, cancella!',
        cancelButtonText: 'Annulla'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('orders.destroy', { order: order.id }), {
                onSuccess: () => {
                    toast.add({severity:'success', summary: 'Successo', detail: 'Ordine cancellato con successo', life: 3000});
                },
                onError: () => {
                    toast.add({severity:'error', summary: 'Errore', detail: 'Errore durante la cancellazione dell\'ordine', life: 3000});
                }
            });
        }
    });
}

</script>
<template>
    <Head title="Ordini" />

    <AuthenticatedLayout>
        <Toast />

        <BaseBlock title="Ordini" class="m-2">
            <template #options>
                <Link
                    :href="route('orders.create')" 
                    class="btn btn-sm btn-alt-primary"
                >
                    <i class="fa fa-plus me-2"></i>
                    Crea
                </Link>
            </template>

            <ContextMenu ref="cm" :model="menuModel">
                <template #item="{ item }">
                    <Link
                        v-if="item.action === 'view'"
                        class="link-dark p-2"
                        :href="route('orders.edit', selected_order?.id)"
                    >
                        <i class="fa fa-pen me-2 link-info"></i>
                        Modifica
                    </Link>
                    <a 
                        v-else-if="item.action === 'print'"
                        class="link-dark p-2"
                        :href="route('orders.show', selected_order?.id)"
                    >
                        <i class="fa fa-print me-2 link-info"></i>
                        Stampa
                    </a>

                    <button class="btn btn-link link-dark p-2" type="button" v-else>
                        <i class="fa fa-trash me-2 link-danger"></i>
                        Cancella
                    </button>
                </template>
            </ContextMenu>

            <DataTable
                :value="orders"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                stripedRows
                filterDisplay="menu"
                v-model:filters="filters"
                contextMenu 
                v-model:contextMenuSelection="selected_order"
                @rowContextmenu="onRowContextMenu"
                editMode="cell"
                @cell-edit-complete="onCellEditComplete"
            >
                <template #empty>
                    <NoItemsFound message="Nessun ordine trovato" icon="fa fa-box-open" />
                </template>
                <Column field="id" header="#" />
                <Column field="customer.description" header="Cliente" :show-filter-match-modes="false">
                    <template #body="{ data }">
                        <Link
                            :href="route('customers.edit', { customer : data.customer.id })"
                        >
                            <span v-text="data.customer.description" />
                        </Link>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            placeholder="Cerca cliente"
                        />
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-filters btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times"></i>
                        </button>
                    </template>
                </Column>
                <Column field="brand.name" header="Brand" filterField="brand.id" :show-filter-match-modes="false">
                    <template #filter="{ filterModel, filterCallback }">
                        <MultiSelect 
                            v-model="filterModel.value" 
                            :options="brands" 
                            optionLabel="name" 
                            optionValue="id" 
                            appendTo="self"
                            @change="filterCallback()" 
                            placeholder="Cerca Marchio" 
                            class="w-100"
                        />
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-filters btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times"></i>
                        </button>
                    </template>
                    <template #editor="{ data }">
                        <Select 
                            v-model="data.brand_id"
                            :options="brands"
                            optionLabel="name"
                            optionValue="id"
                            appendTo="body"
                            class="w-100"
                        />
                    </template>
                </Column>
                <Column field="total" header="Totale">
                    <template #body="{ data }">
                        {{ data.total }} &euro;
                    </template>
                </Column>
                <Column field="payment_status.name" header="Stato Pagamento" filterField="payment_status.id" :show-filter-match-modes="false">
                    <template #body="{ data }">
                        <Tag 
                            v-text="data.payment_status.name"
                            :severity="data.payment_status.bs_color"
                        />

                        <span v-if="data.payment_status.id === 3">&nbsp; ({{ data.downpayment }}) &euro;</span>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <MultiSelect 
                            v-model="filterModel.value" 
                            :options="payment_statuses" 
                            optionLabel="name" 
                            optionValue="id" 
                            appendTo="self"
                            @change="filterCallback()" 
                            placeholder="Seleziona stato" 
                            class="w-100"
                        />
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-filters btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times"></i>
                        </button>
                    </template>
                </Column>
                <Column field="order_date" header="Data ordine" :show-filter-match-modes="false">
                    <template #body="{ data }">
                        {{ moment(data.order_date).format('DD/MM/YYYY') }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <DatePicker
                            v-model="filterModel.value"
                            dateFormat="dd/mm/yy"
                            @update:model-value="filterCallback()"
                        />
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-filters btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times"></i>
                        </button>
                    </template>
                    <template #filterapply>
                    </template>
                </Column>
                <Column field="status.name" header="Stato Ordine" filterField="status.id" :show-filter-match-modes="false">
                    <template #body="{ data }">
                        <Tag 
                            v-text="data.status.name"
                            :severity="data.status.bs_color"
                        />
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                       <MultiSelect 
                            v-model="filterModel.value" 
                            :options="statuses" 
                            optionLabel="name" 
                            optionValue="id" 
                            appendTo="self"
                            @change="filterCallback()" 
                            placeholder="Seleziona stato" 
                            class="w-100"
                        />
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-filters btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times"></i>
                        </button>
                    </template>
                    <template #editor="{ data }">
                        <Select 
                            v-model="data.order_status_id"
                            :options="statuses"
                            optionLabel="name"
                            optionValue="id"
                            appendTo="body"
                            class="w-100"
                        />
                    </template>
                </Column>
            </DataTable>
        </BaseBlock>

    </AuthenticatedLayout>
</template>
<style scoped>
    .btn-filters {
        width: 2.5rem
    }
</style>