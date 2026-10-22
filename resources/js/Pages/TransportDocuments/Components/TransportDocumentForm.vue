<script setup>
import InputText from "primevue/inputtext";
import Datepicker from "primevue/datepicker";
import Select from "primevue/select";
import MultiSelect from "primevue/multiselect";
import Textarea from "primevue/textarea";

import InputError from "@/Components/InputError.vue";

const props = defineProps({
    form: Object,
    workings: Array,
    workshops: Array,
    errors: Object,
});
</script>
<template>
    <div class="container-fluid">
        <div class="row pb-3">
            <div class="col-md-4">
                <label for="document_id" class="form-label">ID DDT</label>
                <InputText
                    id="document_id"
                    v-model="form.document_id"
                    class="w-100"
                />
                <InputError :message="errors.document_id" class="mt-2" />
            </div>

            <div class="col-md-4">
                <label for="workshop_id" class="form-label">Officina</label>
                <Select
                    id="workshop_id"
                    v-model="form.workshop_id"
                    :options="workshops"
                    option-label="name"
                    option-value="id"
                    placeholder="Seleziona officina"
                    class="w-100"
                />
                <InputError :message="errors.workshop_id" class="mt-2" />
            </div>
            <div class="col-md-4">
                <label for="workings" class="form-label">Lavorazioni</label>
                <MultiSelect
                    v-model="form.workings"
                    :options="workings"
                    optionLabel="label"
                    optionValue="value"
                    filter
                    placeholder="Seleziona lavorazioni"
                    class="w-100"
                />
            </div>
        </div>

        <div class="row pb-3 align-items-center">
            <div class="col-md-6">
                <label for="date" class="form-label">Data</label>
                <Datepicker
                    id="date"
                    v-model="form.date"
                    type="date"
                    class="w-100"
                    dateFormat="dd/mm/yy"
                />
                <InputError :message="errors.date" class="mt-2" />
            </div>

            <div class="col-md-6">
                <label for="notes" class="form-label">Note</label>
                <Textarea id="notes" v-model="form.notes" class="w-100" />
                <InputError :message="errors.notes" class="mt-2" />
            </div>
        </div>
    </div>
</template>
