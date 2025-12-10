<template>
  <footer class="bg-[#fafcff] mt-20">
    <!-- === FIND US SECTION (masuk ke footer) === -->
    <FindUsSection>
      <!-- Inject Social Links -->
      <template #socials>
        <SocialLink />
      </template>
    </FindUsSection>

    <!-- Garis pembatas -->
    <div class="border-t border-gray-200 my-10"></div>

    <!-- === FOOTER BAWAH === -->
    <div class="max-w-6xl mx-auto px-4 pb-10 flex flex-col md:flex-row items-center justify-between">
      
      <!-- Logo -->
      <img
        src="/osis-logo.webp"
        alt="Logo OSIS MA Ma'arif"
        class="w-20 opacity-80"
      />

      <!-- Copyright -->
      <p class="text-gray-500 text-sm mt-4 md:mt-0 text-center md:text-left">
        © 2025 OSIS MA Ma’arif Udanawu. All rights reserved.
      </p>

      <!-- Supported By -->
      <div class="mt-4 md:mt-0 opacity-80">
        <img
          src="/supported.webp"
          alt="Supported by"
          class="w-28"
        />
      </div>
    </div>
  </footer>
</template>

<script setup>
import FindUsSection from "@/components/FindUsSection.vue";
import SocialLink from "@/components/SocialLink.vue";
</script>
