import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

export const uiStore = reactive({
  sidebarOpen: false,
  toggleSidebar() { 
    this.sidebarOpen = !this.sidebarOpen 
  },
  closeSidebar() { 
    this.sidebarOpen = false 
  },
})

// Auto-close sidebar when navigating
router.on('navigate', () => uiStore.closeSidebar())
