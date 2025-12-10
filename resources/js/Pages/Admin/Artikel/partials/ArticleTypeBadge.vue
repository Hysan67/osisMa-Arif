<template>
   <span :class="badgeClasses" class="px-2 py-1 rounded-full text-xs font-medium">
     {{ type === 'artikel' ? 'Artikel' : 'Event' }}
   </span>
 </template>
 
 <script setup>
 import { computed } from 'vue';
 
 const props = defineProps({
   type: {
     type: String,
     default: 'artikel',
     validator: (value) => ['artikel', 'event'].includes(value)
   }
 });
 
 const badgeClasses = computed(() => {
   return props.type === 'artikel' 
     ? 'bg-blue-100 text-blue-800' 
     : 'bg-green-100 text-green-800';
 });
 </script>