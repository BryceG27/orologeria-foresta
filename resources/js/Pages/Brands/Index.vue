<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Chip from 'primevue/chip';
import ContextMenu from 'primevue/contextmenu';
import ToggleSwitch from 'primevue/toggleswitch';

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Swal from 'sweetalert2';

const toast = useToast();

const props = defineProps({
    flash : Object,
    errors : Object,
    brands : Array
});

const show_deleted = ref(false);
const selected_brand = ref(null);
const cm = ref(null);
const menuModel = ref([
    {
        label: 'Modifica',
        icon: 'fa fa-pen text-info me-2',
        action : 'edit',
        class: 'btn btn-link link-dark text-start'
    },
    {
        separator: true,
    },
    {
        // label: 'Cancella',
        label: computed(() => selected_brand.value?.deleted_at ? 'Ripristina' : 'Cancella' ) ,
        icon: computed(() => selected_brand.value?.deleted_at ? 'fa fa-undo text-success me-2' : 'fa fa-trash text-danger me-2'),
        action : 'toggle',
        class: 'btn btn-link link-dark text-start',
        command: () => {
            toggleBrand(selected_brand.value);
        }
    }
]);

const brands = computed(() => {
    return props.brands.filter(brand => show_deleted.value || !brand.deleted_at);
})

const toggleBrand = (brand) => {
    if(!brand.deleted_at) {
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
                form.delete(route('brands.destroy', brand.id), {
                    onSuccess : () => {
                        toast.add({ severity: 'success', summary: 'Successo', detail: 'Marchio eliminato con successo.', life: 3000 });
                    },
                    onError : () => {
                        toast.add({ severity: 'error', summary: 'Errore', detail: 'Si è verificato un errore durante l\'eliminazione del marchio.', life: 3000 });
                    }
                });
            }
        })
    } else {
        const form = useForm();
        form.put(route('brands.restore', brand.id), {
            onSuccess : () => {
                toast.add({ severity: 'success', summary: 'Successo', detail: 'Marchio ripristinato con successo.', life: 3000 });
            },
            onError : () => {
                toast.add({ severity: 'error', summary: 'Errore', detail: 'Si è verificato un errore durante il ripristino del marchio.', life: 3000 });
            }
        });
    }
}

const rowClass = (data) => {
    return data.deleted_at ? 'row-deleted' : null;
};

const onRowContextMenu = (event) => {
    cm.value.show(event.originalEvent);
}

onMounted(() => {
    if(props.flash?.success)
        toast.add({ severity: 'success', summary: 'Successo', detail: props.flash.success, life: 3000 });

    if(Object.keys(props.errors || {}).length > 0) {
        toast.add({ severity: 'error', summary: 'Errore', detail: 'Si sono verificati errori nei dati inviati.', life: 3000 });
    }
});
</script>
<template>
    <Head title="Marchi" />

    <Toast />

    <AuthenticatedLayout>
        <BaseBlock title="Marchi" class="m-2">
            <template #options>
                <Link
                    :href="route('brands.create')" 
                    class="btn btn-sm btn-alt-primary"
                >
                    <i class="fa fa-plus me-1"></i>
                    Crea
                </Link>
            </template>

            <ContextMenu ref="cm" :model="menuModel" style="width: 5rem;">
                <template #item="{ item }">
                    <Link 
                        v-if="item.action === 'edit'"
                        :class="item.class"
                        :href="route('brands.edit', selected_brand?.id)"
                    >
                        <i :class="item.icon" />
                        {{ item.label }}
                    </Link>

                    <button 
                        v-else
                        :class="item.class"
                    >
                        <i :class="item.icon" />
                        {{ item.label }}
                    </button>
                </template>
            </ContextMenu>

            <DataTable
                :value="brands"
                :paginator="true"
                :rows="10"
                :rowClass="rowClass"
                :rows-per-page-options="[10, 25, 50]"
                v-model:contextMenuSelection="selected_brand"
                @rowContextmenu="onRowContextMenu"
            >
                <template #header>
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <label for="show_deleted">Mostra eliminati</label>
                        <ToggleSwitch name="show_deleted" id="show_deleted" v-model="show_deleted" />
                    </div>
                </template>

                <template #empty>
                    <NoItemsFound message="Nessun marchio trovato" icon="fa fa-inbox" />
                </template>

                <Column style="width: 30%" header="Nome" field="name" />
                <Column style="width: 50%" header="Logo" field="logo">
                    <template #body="{ data }">
                        <img :src="data.logo" alt="Logo" class="w-10 h-10" v-if="data.logo"/>
                        <span v-else>Nessun logo</span>
                    </template>
                </Column>
                <Column style="width: 20%" header="Stato">
                    <template #body="{ data }">
                        <Chip :class="data.deleted_at ? 'bg-danger text-white' : 'bg-success text-white'" :label="data.deleted_at ? 'Eliminato' : 'Attivo'" />
                    </template>
                </Column>
            </DataTable>
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    :deep(.row-deleted),
    :deep(.row-deleted > td) {
        background-color: #3838384a !important;
        color: #fff !important;
    }
</style>
