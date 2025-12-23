import { defineStore } from 'pinia'
import { loginApi, logoutApi, refreshApi } from '@/requests/AuthRequest.js'

export const useAuthContextStore = defineStore('auth', {
    state: () => ({
        user: null,
        initialized: false,
        refreshing: false,
    }),

    actions: {
        async login(email, password) {
            try {
                const profile = await loginApi(email, password)
                this.user = {
                    username: profile.username,
                    fio: profile.fio,
                    position: profile.position,
                    role: profile.role
                }
                this.initialized = true
                return true
            } catch (e) {
                console.error('login error:', e)
                this.user = null
                this.initialized = true
                return false
            }
        },

        async refresh() {
            try {
                const profile = await refreshApi()
                this.user = {
                    username: profile.username,
                    fio: profile.fio,
                    position: profile.position,
                    role: profile.role
                }
                return true
            } catch (e) {
                this.user = null
                throw e
            }
        },

        async logout() {
            try {
                await logoutApi()
            } finally {
                this.user = null
            }
        }
    }
})
