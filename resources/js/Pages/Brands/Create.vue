<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import BrandForm from './Components/BrandForm.vue';
import ProcessingButton from '@/Components/ProcessingButton.vue';

const props = defineProps({
    errors : Object,
});

const form = useForm({
    name: '',
    img_path: '',
    logo : null
});

const submit = () => {
    form.post(route('brands.store'));
};
</script>
<template>
    <Head title="Crea un marchio" />

    <AuthenticatedLayout>
        <BaseBlock :title="`Modifica marchio - ${brand.name}`" class="m-2">
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
                        :href="route('brands.index')"
                    >
                        <i class="fa fa-times me-1"></i>
                        Annulla
                    </Link>
                </div>
            </template>

            <BrandForm 
                :form="form"
                :errors="errors"
                @submit="submit"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    
</style>