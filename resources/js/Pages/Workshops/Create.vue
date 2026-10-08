<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';
import WorkshopForm from './Components/WorkshopForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    errors: Object
});

const form = useForm({
    name: null,
    address: null,
    email : null,
    phone : null,
    notes : null
});

const submit = () => {
    form.post(route('workshops.store'));
};
</script>
<template>
    <Head title="Nuova officina" />
    
    <AuthenticatedLayout>
        <BaseBlock title="Nuova officina" class="m-2">
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