<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';
import { ref, computed } from 'vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import MultiSelect from 'primevue/multiselect';
import DatePicker from 'primevue/datepicker';

import { FilterMatchMode } from '@primevue/core/api';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

import moment from 'moment';

const props = defineProps({
    flash : Object,
    brands : Array,
    statuses : Array,
    workings : Array
})

const filters = ref({
    working_id : { value : null, matchMode : FilterMatchMode.STARTS_WITH },
    brand_id : { value : null, matchMode : FilterMatchMode.IN },
    'customer.description' : { value : null, matchMode : FilterMatchMode.CONTAINS },
    working_status_id : { value : [1, 2, 3], matchMode : FilterMatchMode.IN },
    delivery_date : { value : null, matchMode : FilterMatchMode.DATE_IS }
})

if(props.flash.success) {
    toast.add({severity:'success', summary: 'Successo', detail: props.flash.success, life: 3000});
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

            <DataTable
                :value="workings"
                :paginator="true"
                :rows="10"
                :rows-per-page-options="[10, 25, 50]"
                filterDisplay="menu"
                v-model:filters="filters"
            >
                <template #empty>
                    <NoItemsFound message="Nessuna lavorazione trovata" />
                </template>

                <!-- <template #header>
                    <div class="d-flex justify-content-end">
                        <IconField>
                            <InputIcon>
                                <i class="fa fa-search" />
                            </InputIcon>
                            <InputText v-model="filters['global'].value" placeholder="Cerca lavorazione" />
                        </IconField>
                    </div>
                </template> -->

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
                </Column>
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>