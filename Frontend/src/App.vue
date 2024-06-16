<script setup>
import ChatComponent from './components/icons/ChatComponent.vue'
</script>

<template>
  <header>
    <router-link to="/" activeClass="active">login</router-link>
    <router-link to="/signup" active-class="active">signup</router-link>
  </header>

  <div>
    <!-- Call the ChatComponent and pass the chatName and chatId props -->
    <ChatComponent 
      chatName="Sample Chat" 
      :chatId="1" 
    />
  </div>
  
</template>

<style scoped>
header {
  line-height: 1.5;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }
}
</style>
