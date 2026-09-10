<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { ref, watchEffect } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import MultiSelect from 'primevue/multiselect';
import DatePicker from 'primevue/datepicker';
import Select from 'primevue/select';
import ContextMenu from 'primevue/contextmenu'; 

import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';
import moment from 'moment';
import Swal from 'sweetalert2';

const toast = useToast();


const props = defineProps({
    flash : Object,
    brands : Array,
    statuses : Array,
    workings : Array
})

const cm = ref();
const selected_working = ref();
const menuModel = ref([
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
            deleteWorking(selected_working);
        }
    }
]);

const deleteWorking = async (working) => {

    const result = await Swal.fire({
        icon: 'warning',
        title: 'Sei sicuro?',
        text: 'Stai per cancellare questa lavorazione',
        showCancelButton: true,
        confirmButtonText: 'Sì, cancella',
        cancelButtonText: 'Annulla',
    })

    if(result.isConfirmed) {
        useForm().delete(route('workings.destroy', { working: working.value.id }), {
            onSuccess: () => {
                toast.add({severity:'success', summary: 'Successo', detail: 'Lavorazione cancellata con successo', life: 3000});
            },
            onError: () => {
                toast.add({severity:'error', summary: 'Errore', detail: 'Si è verificato un errore durante la cancellazione della lavorazione', life: 3000});
            }
        });
    }

    selected_working.value = null;
};

const onRowContextMenu = (event) => {
    cm.value.show(event.originalEvent);
};

const filters = ref({
    working_id : { value : null, matchMode : FilterMatchMode.STARTS_WITH },
    brand_id : { value : null, matchMode : FilterMatchMode.IN },
    'customer.description' : { value : null, matchMode : FilterMatchMode.CONTAINS },
    working_status_id : { value : [1, 2, 3], matchMode : FilterMatchMode.IN },
    delivery_date : { value : null, matchMode : FilterMatchMode.DATE_IS }
})

watchEffect(() => {
    if(props.flash.success) {
        toast.add({severity:'success', summary: 'Successo', detail: props.flash.success, life: 3000});
    }
});

const onCellEditComplete = (event) => {
    let { data, newData, field } = event;

    if(JSON.stringify(data) === JSON.stringify(newData))
        return;

    const form = useForm({...newData})

    form.patch(route('workings.update', { working: data.id }), {
        onSuccess: () => {
            toast.add({severity:'success', summary: 'Successo', detail: 'Lavorazione aggiornata con successo', life: 3000});
        }
    })
}

</script>
<template>
    <Head title="Lavorazioni" />

    <Toast />

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

            <ContextMenu ref="cm" :model="menuModel">
                <template #item="{ item }">
                    <Link 
                        v-if="item.action === 'print'"
                        class="link-dark p-2"
                        :href="route('workings.show', selected_working?.id)"
                    >
                        <i class="fa fa-print me-2 link-info"></i>
                        Stampa
                    </Link>

                    <button class="btn btn-link link-dark p-2" type="button" v-else>
                        <i class="fa fa-trash me-2 link-danger"></i>
                        Cancella
                    </button>
                </template>
            </ContextMenu>

            <DataTable
                :value="workings"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                filterDisplay="menu"
                v-model:filters="filters"
                contextMenu 
                v-model:contextMenuSelection="selected_working"
                @rowContextmenu="onRowContextMenu"
                editMode="cell"
                @cell-edit-complete="onCellEditComplete"
            >
                <template #empty>
                    <NoItemsFound message="Nessuna lavorazione trovata" />
                </template>

                <Column style="width: 5%" header="#" field="working_id" :showFilterMatchModes="false">
                    <template #body="{ data }">
                        <div class="text-center">
                            <Link
                                :href="route('workings.edit', { working : data.id })"
                                v-text="data.working_id"
                            />
                        </div>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText 
                            v-model="filterModel.value" 
                            type="text" 
                            @input="filterCallback()" 
                            placeholder="Cerca #" 
                            class="w-100"
                        />
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times me-1"></i>
                            Cancella
                        </button>  
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                </Column>

                <Column style="width: 25%" header="Cliente" field="customer.description" :showFilterMatchModes="false">
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
                            type="text" 
                            @input="filterCallback()" 
                            placeholder="Cerca Cliente" 
                            class="w-100"
                        />
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times me-1"></i>
                            Cancella
                        </button>  
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                </Column>

                <Column style="width: 15%" header="Marchio" field="brand.name" filterField="brand_id" :showFilterMatchModes="false">
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
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times me-1"></i>
                            Cancella
                        </button>  
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                </Column>
                <Column style="width: 20%" header="Referenza" field="reference" />
                <Column style="width: 15%" header="Consegna" field="delivery_date" :showFilterMatchModes="false">
                    <template #body="{ data }">
                        {{ data.delivery_date ? moment(data.delivery_date).format('DD/MM/YYYY') : '' }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <DatePicker 
                            v-model="filterModel.value" 
                            @update:modelValue="filterCallback" 
                            placeholder="Cerca Consegna" 
                            class="w-100"
                            date-format="dd/mm/yy"
                        />
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times me-1"></i>
                            Cancella
                        </button>  
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                    <template #editor="{ data, field }">
                        <DatePicker 
                            v-model="data.delivery_date" 
                            appendTo="body" 
                            class="w-100"
                            date-format="dd/mm/yy"
                        />
                    </template>
                </Column>

                <Column style="width: 20%" header="Stato" field="status.name" filterField="working_status_id" :showFilterMatchModes="false" >
                    <template #body="{ data }">
                        <span :class="`badge rounded-pill p-2 bg-${data.status.bs_color}`">
                            {{ data.status.name }}
                        </span>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <MultiSelect 
                            v-model="filterModel.value" 
                            :options="statuses" 
                            optionLabel="name" 
                            @change="filterCallback()"
                            optionValue="id" 
                            appendTo="self"
                            placeholder="Cerca Stato" 
                            class="w-100"
                        />
                    </template>
                    <template #filterclear="{ filterCallback }">
                        <button class="btn btn-sm btn-alt-danger" @click="filterCallback()">
                            <i class="fa fa-times me-1"></i>
                            Cancella
                        </button>  
                    </template>
                    <template #filterapply="{ filterCallback }">
                        
                    </template>
                    <template #editor="{ data, field }">
                        <Select 
                            v-model="data.working_status_id" 
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
