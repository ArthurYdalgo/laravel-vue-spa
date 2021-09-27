<template>
  <div v-if="user" class="nav-item dropdown">
    <a
      class="nav-link dropdown-toggle text-dark"
      href="#"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <font-awesome-icon icon="bell" />
      <span
        style="position: absolute; margin-top: 5px"
        v-if="Object.values(notifications).length > 0"
        class="badge badge-danger badge-pill"
        >{{ Object.values(notifications).length }}</span
      >
    </a>
    <div class="dropdown-menu">
      <div
        v-for="notification in Object.values(notifications)"
        v-bind:key="notification.id"
        href="#"
        class="pl-3"
      >
        <fa
          v-if="notification.icon"
          v-bind:icon="notification.icon"
          fixed-width
        />
        {{ notification.title }} - {{ notification.notification }}
        <form style="display: inline">
          <button
            v-on:click="markAsRead(notification.id)"
            type="button"
          >
            <fa icon="check" fixed-width />
          </button>
        </form>
        
        <div class="dropdown-divider" />
      </div>

      <div
        v-if="Object.values(notifications).length == 0"           
        class="pl-3"
      >
        {{$t('you_have_no_notifications')}}        
      </div>

      <div class="dropdown-divider" v-if="Object.values(notifications).length == 0" />
      <a href="#" class="dropdown-item pl-3" @click.prevent="markAllAsRead()">
        {{$t('clear_all_notifications')}}
      </a>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "NotificationDropdown",
  computed: mapGetters({
    user: "auth/user",
    notifications: "notifications/notifications",
  }),
  props: {
    muted: {
      type: Boolean,
      default: false
    }
  },
  mounted(){        
    let user_id = this.user.id;
    Echo.leave(`user-notifications.${user_id}`)
    
    Echo.private(`user-notifications.${user_id}`).listen('.SendUserNotification', (event)=>{
      let user_notification = event.user_notification      
      this.$store.dispatch('notifications/addIncomingNotification', {user_notification})            
      if(!this.$props.muted){
        var audio = new Audio(window.config.notification_sound)      
        audio.play()
      }
    });
  },
  created() {
    // console.log(require('~/assets'))
    this.$store.dispatch("notifications/fetchNotifications");
  },
  methods:{
    markAsRead(notification_id){
      this.$store.dispatch("notifications/markNotificationAsRead", {notification_id});
    },
    markAllAsRead(){
      this.$store.dispatch("notifications/markAllNotificationsAsRead");
    }
  }
};
</script>
