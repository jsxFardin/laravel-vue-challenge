<script setup>
import { computed, defineEmits } from "vue";

const props = defineProps({
  totalItems: Number,
  currentPage: Number,
  perPage: Number,
});

const emits = defineEmits(["update:currentPage"]);

const totalPages = computed(() => {
  return Math.ceil(props.totalItems / props.perPage);
});

function goToPage(page) {
  emits("update:currentPage", page);
}
</script>
<template>
  <div class="flex justify-between items-center my-4">
    <button
      :disabled="currentPage === 1"
      @click="goToPage(currentPage - 1)"
      class="bg-gray-800 py-2 px-4 text-sm font-medium text-gray-300 hover:bg-indigo-700"
    >
      Previous
    </button>
    <ul class="flex space-x-1">
      <li v-for="page in totalPages" :key="page">
        <button
          @click="goToPage(page)"
          :disabled="currentPage === page"
          class="cursor-pointer py-2 px-4 leading-tight border border-gray-600 text-gray-400 hover:bg-indigo-700 hover:text-white"
          :class="[
            currentPage === page ? 'bg-indigo-600 text-white' : 'bg-gray-800',
          ]"
          >{{ page }}
        </button>
      </li>
    </ul>
    <button
      :disabled="currentPage === totalPages"
      @click="goToPage(currentPage + 1)"
      class="bg-gray-800 py-2 px-4 text-sm font-medium text-gray-300 hover:bg-indigo-700"
    >
      Next
    </button>
  </div>
</template>