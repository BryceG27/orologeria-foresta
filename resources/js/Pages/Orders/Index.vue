<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Ordini" />

    <AuthenticatedLayout>
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
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
    
</style>