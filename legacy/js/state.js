/**
 * WMS State Management
 * Persistent using LocalStorage
 */

const DEFAULT_DATA = {
    Produk: [
        { id: 'PRD-001', name: 'Kabel UTP Cat 6', brand: 'Belden', type: 'Indoor', unit: 'Roll', price: 1200000, stock: 150 },
        { id: 'PRD-002', name: 'Router Wireless', brand: 'MikroTik', type: 'hAP ac2', unit: 'Pcs', price: 950000, stock: 12 }
    ],
    Customer: [
        { id: 'CST-001', name: 'Toko Maju Jaya', contact: 'Bp. Budi', address: 'Jl. Merdeka No. 10', phone: '0812-3456-7890' },
        { id: 'CST-002', name: 'CV Berkah Net', contact: 'Ibu Ani', address: 'Jl. Sudirman No. 45', phone: '0811-2222-3333' }
    ],
    Supplier: [
        { id: 'SPL-001', name: 'PT Sinar Abadi', category: 'Peripheral', city: 'Jakarta', phone: '021-5556677' },
        { id: 'SPL-002', name: 'Global Tech Disti', category: 'Network', city: 'Surabaya', phone: '031-8889900' }
    ],
    Gudang: [
        { id: 'GDN-001', name: 'Gudang Utama', type: 'Inbound/Outbound', pic: 'Tepe Zhavarez', capacity: '10.000 m2' },
        { id: 'GDN-002', name: 'Gudang Transit', type: 'Distribution', pic: 'Bp. Rahmat', capacity: '2.500 m2' }
    ],
    Transactions: []
};

const WMSState = {
    init() {
        if (!localStorage.getItem('wms_data')) {
            localStorage.setItem('wms_data', JSON.stringify(DEFAULT_DATA));
        }
    },

    getData() {
        this.init();
        return JSON.parse(localStorage.getItem('wms_data'));
    },

    saveData(data) {
        localStorage.setItem('wms_data', JSON.stringify(data));
        // Dispatch custom event for real-time updates if multiple windows are open
        window.dispatchEvent(new Event('wms_state_updated'));
    },

    get(key) {
        return this.getData()[key] || [];
    },

    add(key, item) {
        const data = this.getData();
        if (!data[key]) data[key] = [];
        data[key].push(item);
        this.saveData(data);
    },

    remove(key, index) {
        const data = this.getData();
        data[key].splice(index, 1);
        this.saveData(data);
    },

    updateStock(productId, delta) {
        const data = this.getData();
        const product = data.Produk.find(p => p.id === productId);
        if (product) {
            product.stock = (product.stock || 0) + delta;
            this.saveData(data);
        }
    },

    addTransaction(type, mitra, items, total) {
        const data = this.getData();
        const tx = {
            id: (type === 'Masuk' ? 'PO' : 'SJ') + '-' + Date.now().toString().slice(-6),
            type,
            mitra,
            items,
            total,
            date: new Date().toISOString(),
            status: 'Completed'
        };
        data.Transactions.unshift(tx);
        
        // Update stock for each item
        items.forEach(item => {
            const delta = type === 'Masuk' ? parseInt(item.qty) : -parseInt(item.qty);
            const product = data.Produk.find(p => p.id === item.productId || p.name === item.name);
            if (product) {
                product.stock = (product.stock || 0) + delta;
            }
        });

        this.saveData(data);
        return tx;
    }
};

WMSState.init();
window.WMSState = WMSState;
