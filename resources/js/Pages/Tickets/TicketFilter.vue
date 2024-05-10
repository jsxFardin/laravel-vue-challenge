<script setup>
import { ref, watch, defineEmits } from "vue";
import { useDateUtils } from "@/Utilities/DateUtils";
import VueTailwindDatepicker from "vue-tailwind-datepicker";

defineProps({
  statuses: Array,
  priorities: Array,
});

const { formatDate } = useDateUtils();
const emits = defineEmits(['changeFilter']);

const filter = ref({
  status: "",
  priority: "",
  search: "",
  from_date: "",
  to_date: "",
});
const dateValue = ref([]);
const formatter = ref({
  date: 'DD MMM YYYY',
  month: 'MMM',
})

const changeFilter = () => {
    emits('changeFilter', filter.value);
}


watch(
  () => dateValue.value,
  (value) => {
    if (value.length > 0) {
      filter.value.from_date = formatDate(value[0]);
      filter.value.to_date = formatDate(value[1]);
    } else {
      filter.value.from_date = "";
      filter.value.to_date = "";
    }
    changeFilter();
  },
);

</script>

<template>
  <div
    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
  >
    <div class="w-full md:w-1/4">
      <div class="flex items-center">
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
          <div
            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
          >
            <svg
              aria-hidden="true"
              class="w-5 h-5 text-gray-500 dark:text-gray-400"
              fill="currentColor"
              viewbox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"
              />
            </svg>
          </div>
          <input
            v-model="filter.search"
            @input="changeFilter"
            type="text"
            id="simple-search"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="Search"
            required=""
          />
        </div>
      </div>
    </div>
    <div
      class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-grow"
    >
      <div class="flex items-center space-x-3 w-full">
        <VueTailwindDatepicker v-model="dateValue" separator=" - " :formatter="formatter" input-classes="py-2 px-3 pr-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
        <select
          id="priority"
          name="priority"
          v-model="filter.priority"
          @change="changeFilter"
          class=" block py-2 px-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        >
          <option value="">Slect Priority</option>
          <option
            v-for="(label, priority) in priorities"
            :key="priority"
            :value="priority"
          >
            {{ label }}
          </option>
        </select>
        <select
          id="status"
          name="status"
          v-model="filter.status"
          @change="changeFilter"
          class=" py-2 px-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
        >
          <option value="">Slect Status</option>
          <option
            v-for="(label, status) in statuses"
            :key="status"
            :value="status"
          >
            {{ label }}
          </option>
        </select>
      </div>
    </div>
  </div>
</template>