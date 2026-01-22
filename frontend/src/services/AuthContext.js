import { defineStore } from 'pinia'
import { loginApi, logoutApi, refreshApi } from '@/requests/AuthRequest.js'

export const useAuthContextStore = defineStore('auth', {
    state: () => ({
        user: null,
        initialized: false,
        refreshing: false,
    }),

    actions: {
        async init() {
            if (this.initialized || this.refreshing) return

            this.refreshing = true
            try {
                await this.refresh()
            } catch {
                this.user = null
            } finally {
                this.initialized = true
                this.refreshing = false
            }
        },

        async login(email, password) {
            const profile = await loginApi(email, password)
            this.user = {
                username: profile.username,
                fio: profile.fio,
                position: profile.position,
                role: profile.role
            }
            this.initialized = true
            return true
        },

        async refresh() {
            const profile = await refreshApi()
            this.user = {
                username: profile.username,
                fio: profile.fio,
                position: profile.position,
                role: profile.role
            }
        },

        async logout() {
            try {
                await logoutApi()
            } finally {
                this.user = null
                this.initialized = true
            }
        }
    }
})

