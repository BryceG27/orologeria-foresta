<script setup>
import { reactive, computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { InputText, Password } from 'primevue'

import { required, minLength } from "@vuelidate/validators";

const props = defineProps({
    errors: Object,
});

// Input state variables
const state = reactive({
    username: null,
    password: null,
});

// Validation rules
const rules = computed(() => {
    return {
        email: {
            required,
            minLength: minLength(3),
        },
        password: {
            required,
            minLength: minLength(5),
        },
    };
});

const form = useForm({
    email : '',
    password : '' 
});


// On form submission
async function onSubmit() {
    form.post(route('login'));
}
</script>

<template>
    <!-- Page Content -->
    <Head title="Login" />
    <BaseBackground image="/assets/media/photos/photo31@2x.jpg">
        <div class="row g-0 bg-primary-dark-op">
            <!-- Meta Info Section -->
            <div
                class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center"
            >
                <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <Link
                        :href="route('dashboard')"
                        class="link-fx fw-semibold fs-2 text-white"
                        >
                        <span class="fw-normal">Orologeria </span>Foresta
                    </Link>
                    <p class="text-white-75 me-xl-8 mt-2">
                        Welcome to your amazing app. Feel free to login and start managing
                        your projects and clients.
                    </p>
                </div>
            </div>
            <div
                class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm"
            >
                <p class="fw-medium text-white-50 mb-0">
                <!-- <strong>{{ store.app.name + " " + store.app.version }}</strong>
                    &copy; {{ store.app.copyright }} -->
                </p>
                <ul class="list list-inline mb-0 py-2">
                    <li class="list-inline-item">
                        <a class="text-white-75 fw-medium" href="javascript:void(0)"
                        >Legal</a
                        >
                    </li>
                    <li class="list-inline-item">
                        <a class="text-white-75 fw-medium" href="javascript:void(0)"
                        >Contact</a
                        >
                    </li>
                    <li class="list-inline-item">
                        <a class="text-white-75 fw-medium" href="javascript:void(0)"
                        >Terms</a
                        >
                    </li>
                </ul>
            </div>
        </div>
        <!-- END Meta Info Section -->
    
    <!-- Main Section -->
        <div
            class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-extra-light"
        >
            <div class="p-3 w-100 d-lg-none text-center">
                <Link
                    :href="route('dashboard')"
                    class="link-fx fw-semibold fs-3 text-dark"
                >
                    Orologeria
                    <span class="fw-normal">Foresta</span>
                </Link>
            </div>
            <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                <div class="w-100">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <p class="mb-3">
                            <img src="/assets/media/various/Logo.png" alt="" class="rounded-3" style="width: 17rem">
                        </p>
                        <h1 class="fw-bold mb-2">Entra nel portale</h1>
                        <p class="fw-medium text-muted">
                            Benvenuto, effettua il login o
                            <Link :href="{ name: 'auth-signup3' }">registrati</Link>
                            per creare un nuovo account.
                        </p>
                    </div>
                    <!-- END Header -->

                    <!-- Sign In Form -->
                    <div class="row g-0 justify-content-center">
                        <div class="col-sm-8 col-xl-4">
                            <form @submit.prevent="onSubmit">
                                <div class="mb-4">
                                    <InputText
                                        type="text"
                                        class="py-3 w-100"
                                        id="login-username"
                                        name="login-username"
                                        placeholder="Email"
                                        :invalid="errors.email != undefined"
                                        :style="`background-color: ${errors.email ? '#f9dbe1' : '#ebeef2'}`"
                                        v-model="form.email"
                                    />
                                    <div
                                        v-if="errors.email"
                                        class="text-danger"
                                    >
                                        Per favore, inserisci la tua email
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <Password 
                                        class="w-100"
                                        inputClass="w-100 h-100 py-3"
                                        id="login-password"
                                        name="login-password"
                                        placeholder="Password"
                                        :feedback="false"
                                        :toggle-mask="true"
                                        :invalid="errors.password != undefined"
                                        v-model="form.password"
                                        :inputStyle="{
                                            'backgroundColor' : errors.password ? '#f9dbe1' : '#ebeef2'
                                        }"
                                        @keydown.enter="onSubmit"
                                    />
                                    <div
                                        v-if="errors.password"
                                        class="text-danger"
                                    >
                                        Per favore, inserisci la tua password
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-center mb-4"
                                >
                                    <Link
                                        :to="{ name: 'auth-reminder3' }"
                                        class="text-muted fs-sm fw-medium d-block d-lg-inline-block mb-1"
                                    >
                                        Password dimenticata?
                                    </Link>
                                    <div>
                                        <button type="submit" class="btn btn-lg btn-alt-primary" v-if="!form.processing">
                                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i>
                                            Entra
                                        </button>
                                        <button type="button" class="btn btn-lg btn-alt-primary" disabled v-else>
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Caricamento...
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Sign In Form -->
                </div>
            </div>
            <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                <p class="fw-medium text-black-50 py-2 mb-0">
                <!-- <strong>{{ store.app.name + " " + store.app.version }}</strong>
                    &copy; {{ store.app.copyright }} -->
                </p>
                <ul class="list list-inline py-2 mb-0">
                    <li class="list-inline-item">
                        <a class="text-muted fw-medium" href="javascript:void(0)"
                        >Legal</a
                        >
                    </li>
                    <li class="list-inline-item">
                        <a class="text-muted fw-medium" href="javascript:void(0)">Contact</a>
                    </li>
                    <li class="list-inline-item">
                        <a class="text-muted fw-medium" href="javascript:void(0)">Terms</a>
                    </li>
                </ul>
            </div>
        </div>
            <!-- END Main Section -->
    </div>
    </BaseBackground>
<!-- END Page Content -->
</template>
