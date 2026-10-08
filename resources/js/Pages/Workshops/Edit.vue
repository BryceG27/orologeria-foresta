<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import WorkshopForm from './Components/WorkshopForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    workshop: Object,
    errors: Object
});

const form = useForm({
    name: props.workshop.name,
    address: props.workshop.address,
    email : props.workshop.email,
    phone : props.workshop.phone,
    notes : props.workshop.notes
});

const submit = () => {
    form.patch(route('workshops.update', { workshop: props.workshop.id }));
};
</script>
<template>
    <Head title="Modifica officina" />
    
    <AuthenticatedLayout>
        <BaseBlock title="Modifica officina" class="m-2">
            <template #options>
                <div class="d-flex justify-content-end gap-2">
                    <button 
                        class="btn btn-sm btn-alt-success" 
                        v-if="!form.processing"
                        @click="submit()"
                    >
                        <i class="fa fa-save me-1"></i>
                        Salva
                    </button>
                    <ProcessingButton v-else />
                    <Link 
                        class="btn btn-sm btn-alt-danger"
                        :href="route('workshops.index')"
                    >
                        <i class="fa fa-times me-1"></i>
                        Annulla
                    </Link>
                </div>
            </template>

            <WorkshopForm 
                :form="form" 
                :errors="errors"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    .justify-content-end .btn {
        min-width: 5rem
    }
</style>