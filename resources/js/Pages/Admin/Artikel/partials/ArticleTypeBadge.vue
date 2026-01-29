<template>
  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
    :class="{
      'bg-blue-100 text-blue-800': type === 'artikel',
      'bg-green-100 text-green-800': type === 'event',
      'bg-yellow-100 text-yellow-800': type === 'pengumuman'
    }">
    {{ type }}
  </span>
</template>

<script setup>
defineProps({
  type: {
    type: String,
    default: 'artikel',
    validator: (value) => ['artikel', 'event', 'pengumuman'].includes(value)
  }
});
</script>