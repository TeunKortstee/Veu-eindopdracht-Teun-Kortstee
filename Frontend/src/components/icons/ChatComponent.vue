<!-- src/components/ChatComponent.vue -->
<template>
  <div class="mx-auto">
    <div class="card shadow-sm text-center mb-1">
      <div class="card-body">
        {{ chatName }}
      </div>
      <a :href="`/chats/chat?id=${chatId}&name=${chatName}`" class="stretched-link"></a>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ChatComponent',
  props: {
    chatName: {
      type: String,
      required: true
    },
    chatId: {
      type: Number,
      required: true
    }
  }
}
</script>

<style scoped>
/* Add your styles here */
.mx-auto{
    width: 400px;
}
</style>
