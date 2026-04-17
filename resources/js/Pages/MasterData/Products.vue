<script setup>
import MasterDataLayout from '@/Layouts/MasterDataLayout.vue';
import ResponsiveTable from '@/Components/ResponsiveTable.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PhNotePencil, PhTrash, PhTag, PhCube } from "@phosphor-icons/vue";

const props = defineProps({
    products: Object,
    filters: Object
});

const showModal = ref(false);
const editingProduct = ref(null);

const form = useForm({
    kode_barang: '',
    nama: '',
    merk: '',
    tipe: '',
    satuan: 'Roll',
    harga: '',
    stok_minimum: 10
});

const openModal = (product = null) => {
    editingProduct.value = product;
    if (product) {
        form.kode_barang = product.kode_barang;
        form.nama = product.nama;
        form.merk = product.merk;
        form.tipe = product.tipe;
        form.satuan = product.satuan;
        form.harga = product.harga;
        form.stok_minimum = product.stok_minimum;
    } else {
        form.reset();
        // Auto-gen code example
        form.kode_barang = 'PRD-' + Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    }
    showModal.value = true;
};

const submit = () => {
    if (editingProduct.value) {
        form.put(route('products.update', editingProduct.value.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('products.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteProduct = (id) => {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        form.delete(route('products.destroy', id));
    }
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    editingProduct.value = null;
};

const handleSearch = (val) => {
    // Inertia search logic here
};
</script>

<template>
    <Head title="Master Data Produk" />

    <MasterDataLayout 
        title="Master Data" 
        active-tab="Produk" 
        add-button-label="Tambah Produk"
        @add="openModal()"
        @search="handleSearch"
    >
        <ResponsiveTable :headers="['Kode', 'Nama & Tipe', 'Satuan', 'Harga']" :items="products.data">
            <template #row="{ item }">
                <td class="px-8 py-5">
                    <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100 uppercase tracking-wider">
                        {{ item.kode_barang }}
                    </span>
                </td>
                <td class="px-8 py-5">
                    <div class="font-black text-slate-800 tracking-tight">{{ item.nama }}</div>
                    <div class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ item.merk }} / {{ item.tipe }}</div>
                </td>
                <td class="px-8 py-5 text-sm font-bold text-slate-600 tracking-tight">{{ item.satuan }}</td>
                <td class="px-8 py-5 text-sm font-black text-slate-800 tracking-tight text-right">Rp {{ Number(item.harga).toLocaleString('id-ID') }}</td>
                <td class="px-8 py-5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button @click="openModal(item)" class="p-2.5 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all active:scale-90">
                            <PhNotePencil :size="20" weight="bold" />
                        </button>
                        <button @click="deleteProduct(item.id)" class="p-2.5 text-rose-500 hover:bg-rose-50 rounded-xl transition-all active:scale-90">
                            <PhTrash :size="20" weight="bold" />
                        </button>
                    </div>
                </td>
            </template>

            <template #mobile-card="{ item }">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <PhCube :size="20" weight="fill" />
                        </div>
                        <div>
                            <div class="font-black text-slate-800 tracking-tight">{{ item.nama }}</div>
                            <div class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ item.kode_barang }}</div>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <button @click="openModal(item)" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                            <PhNotePencil :size="20" weight="bold" />
                        </button>
                        <button @click="deleteProduct(item.id)" class="p-2 text-slate-400 hover:text-rose-500 transition-colors">
                            <PhTrash :size="20" weight="bold" />
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Merk/Tipe</p>
                        <p class="text-sm font-bold text-slate-700 tracking-tight">{{ item.merk }} / {{ item.tipe }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga / Satuan</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">Rp {{ Number(item.harga).toLocaleString('id-ID') }} <span class="text-[10px] text-slate-400 font-bold">/ {{ item.satuan }}</span></p>
                    </div>
                </div>
            </template>

            <template #pagination>
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Showing {{ products.from || 0 }}-{{ products.to || 0 }} of {{ products.total }}</p>
                    <!-- Simple pagination buttons -->
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition active:scale-95 disabled:opacity-50">Prev</button>
                        <button class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition active:scale-95">Next</button>
                    </div>
                </div>
            </template>
        </ResponsiveTable>

        <Modal :show="showModal" :title="editingProduct ? 'Edit Produk' : 'Tambah Produk Baru'" @close="closeModal">
            <form @submit.prevent="submit" class="flex flex-col h-full md:h-auto">
                <div class="p-6 md:p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest ml-1">Kode</label>
                            <input type="text" v-model="form.kode_barang" disabled class="input-base !bg-slate-50 !border-slate-100 font-bold text-indigo-600">
                            <InputError :message="form.errors.kode_barang" />
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest ml-1">Nama Produk</label>
                            <input type="text" v-model="form.nama" required class="input-base font-bold" placeholder="Nama barang...">
                            <InputError :message="form.errors.nama" />
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest ml-1">Merk</label>
                            <input type="text" v-model="form.merk" class="input-base font-bold" placeholder="Merk barang...">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest ml-1">Varian/Tipe</label>
                            <input type="text" v-model="form.tipe" class="input-base font-bold" placeholder="Tipe/Varian...">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest ml-1">Satuan</label>
                            <select v-model="form.satuan" class="input-base font-bold appearance-none">
                                <option>Roll</option>
                                <option>Pcs</option>
                                <option>Box</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 mb-2 uppercase tracking-widest ml-1">Harga</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">Rp</span>
                                <input type="number" v-model="form.harga" placeholder="0" class="input-base !pl-10 font-black">
                            </div>
                            <InputError :message="form.errors.harga" />
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-0 bg-slate-50/80 backdrop-blur-md p-6 md:p-8 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 mt-auto shrink-0">
                    <button type="button" @click="closeModal" class="btn-secondary w-full sm:w-auto">Batal</button>
                    <button type="submit" :disabled="form.processing" class="btn-primary w-full sm:w-auto">
                        {{ editingProduct ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </button>
                </div>
            </form>
        </Modal>
    </MasterDataLayout>
</template>
