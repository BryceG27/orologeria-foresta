<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProcessingButton from "@/Components/ProcessingButton.vue";
import TransportDocumentForm from "./Components/TransportDocumentForm.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    document: Object,
    errors: Object,
    workings: Array,
    workshops: Array,
});

const workings = computed(() => {
    return props.workings.map((w) => ({
        label: `${w.customer.surname ?? w.customer.company_name} - ${w.brand.name}`,
        value: w.id,
    }));
});

const form = useForm({
    document_id: props.document.document_id,
    workshop_id: props.document.workshop_id,
    workings: props.document.workings.map((w) => w.id),
    date: new Date(props.document.date),
    notes: props.document.notes,
});

const submit = () => {
    form.patch(
        route("transport-documents.update", {
            transport_document: props.document.id,
        }),
    );
};
</script>
<template>
    <Head title="Modifica DDT" />

    <AuthenticatedLayout>
        <BaseBlock title="Modifica DDT" class="m-2">
            <template #options>
                <div class="d-flex justify-content-end gap-2">
                    <button
                        class="btn btn-sm btn-alt-success"
                        type="submit"
                        v-if="!form.processing"
                        @click="submit"
                    >
                        <i class="fa fa-save me-1"></i>
                        Salva
                    </button>

                    <ProcessingButton v-else />

                    <Link
                        class="btn btn-sm btn-alt-danger"
                        :href="route('transport-documents.index')"
                    >
                        <i class="fa fa-times me-1"></i>
                        Annulla
                    </Link>
                </div>
            </template>

            <TransportDocumentForm
                :form="form"
                :workings="workings"
                :workshops="workshops"
                :errors="errors"
            />
        </BaseBlock>
    </AuthenticatedLayout>
</template>
<style scoped>
.justify-content-end .btn {
    min-width: 5rem;
}
</style>
