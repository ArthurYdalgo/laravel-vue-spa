import axios from 'axios'
import * as types from '../mutation-types'
import Vue from 'vue'

// state
export const state = {
  notifications: {}
}

// getters
export const getters = {
  notifications: state => state.notifications
}

// mutations
export const mutations = {
  [types.FETCH_NOTIFICATIONS_SUCCESS] (state, { notifications }) {
    state.notifications = notifications
  },
  [types.FETCH_NOTIFICATIONS_FAILURE] (state) {
    state.notifications = {}
  },
  [types.MARK_ALL_NOTIFICATIONS_AS_READ_SUCCESS] (state, { notifications }) {
    state.notifications = notifications
  },
  [types.MARK_NOTIFICATION_AS_READ_SUCCESS] (state) {        
  },
  [types.MARK_ALL_NOTIFICATIONS_AS_READ_FAILURE] (state) {    
  },
  [types.MARK_NOTIFICATION_AS_READ_FAILURE] (state) {
  },
  [types.ADD_INCOMING_NOTIFICATION_SUCCESS] (state, {notifications}) {   
    state.notifications = notifications     
  },
  [types.ADD_INCOMING_NOTIFICATION_FAILURE] (state) {    
  },
}


// actions
export const actions = {
  async fetchNotifications ({ commit }) {
    try {
      const { data } = await axios.get('/api/user-notifications')         

      commit(types.FETCH_NOTIFICATIONS_SUCCESS, { notifications: data })
    } catch (e) {
      commit(types.FETCH_NOTIFICATIONS_FAILURE)
    }
  },
  async markAllNotificationsAsRead ({ commit }) {
    try {
      await axios.post('/api/user-notifications/mark-all-as-read')

      commit(types.MARK_ALL_NOTIFICATIONS_AS_READ_SUCCESS, { notifications: {} })
    } catch (e) {
      commit(types.MARK_ALL_NOTIFICATIONS_AS_READ_FAILURE)
    }
  },
  async markNotificationAsRead ({ commit } , {notification_id}) {
    try {
      await axios.post(`/api/user-notifications/mark-as-read/${notification_id}`);

      Vue.delete(state.notifications, notification_id)

      commit(types.MARK_NOTIFICATION_AS_READ_SUCCESS)
    } catch (e) {
      commit(types.MARK_NOTIFICATION_AS_READ_FAILURE)
    }
  },
  addIncomingNotification({commit}, {user_notification}){
    try {                      
      let notifications = state.notifications
      notifications[user_notification.id] = user_notification
      state.notifications = {...notifications }      

      commit(types.ADD_INCOMING_NOTIFICATION_SUCCESS, {notifications})
    } catch (e) {
      console.log(e)
      commit(types.ADD_INCOMING_NOTIFICATION_FAILURE)
    }
  }
}
