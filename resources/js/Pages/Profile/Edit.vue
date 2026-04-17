<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { PhUserCircle, PhShieldCheck, PhWarning } from "@phosphor-icons/vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profil Saya" />

    <AuthenticatedLayout title="Profil Saya">
        <div class="max-w-4xl mx-auto font-sans pb-20">
            <div class="flex items-center gap-4 mb-10">
                <div class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100">
                    <PhUserCircle :size="32" weight="fill" class="text-indigo-600" />
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Akun Saya</h1>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Kelola Keamanan & Informasi Personal</p>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex items-center gap-3">
                        <PhUserCircle :size="20" weight="bold" class="text-indigo-600" />
                        <h2 class="font-black text-slate-800 text-sm uppercase tracking-widest">Informasi Profil</h2>
                    </div>
                    <div class="p-8 md:p-10">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex items-center gap-3">
                        <PhShieldCheck :size="20" weight="bold" class="text-indigo-600" />
                        <h2 class="font-black text-slate-800 text-sm uppercase tracking-widest">Keamanan Kata Sandi</h2>
                    </div>
                    <div class="p-8 md:p-10">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>

                <div class="bg-rose-50/30 rounded-[2.5rem] border border-rose-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-rose-100 bg-rose-100/20 flex items-center gap-3">
                        <PhWarning :size="20" weight="bold" class="text-rose-600" />
                        <h2 class="font-black text-rose-800 text-sm uppercase tracking-widest">Zona Berbahaya</h2>
                    </div>
                    <div class="p-8 md:p-10">
                        <DeleteUserForm class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
