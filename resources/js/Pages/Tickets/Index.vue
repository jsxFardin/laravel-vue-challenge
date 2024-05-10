<script setup>
import Pagination from "@/Components/Pagination.vue";
import { watch, ref } from "vue";
import { Link, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useDateUtils } from "@/Utilities/DateUtils";

const props = defineProps({
  tickets: Array,
});

const { formatDateTime } = useDateUtils();
const ticketDataSet = ref([]);
const queryParams = ref({
  page: route().params.page ?? 1,
  sort: route().params.sort ?? "desc",
  name: route().params.name ?? "id",
  per_page: route().params.per_page ?? 10,
});

watch(
  () => props.tickets,
  (value) => {
    ticketDataSet.value = value.data;
  },
  { immediate: true }
);

const getTickets = (targetPage) => {
    queryParams.value.page = targetPage
    let url = route(`tickets.index`, queryParams.value);
    // Inertia.get(url, queryParams.value, {  preserveState: true });
    router.get(url, queryParams.value, {  preserveState: true });
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="flex justify-between items-center py-6">
      <h1 class="text-2xl font-semibold text-gray-100">Tickets</h1>
      <a
        href="/tickets/create"
        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Create Ticket
      </a>
    </div>
    <div class="overflow-x-auto shadow sm:rounded-lg">
      <table class="min-w-full divide-y divide-gray-700">
        <thead class="">
          <tr>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              ID
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              Submitted
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              Title
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              User
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              Priority
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              Status
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider"
            >
              &nbsp;
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
          <tr v-for="ticket in ticketDataSet" :key="ticket.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
              {{ ticket.id }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
              {{ formatDateTime(ticket.created_at) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">
              {{ ticket.title }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
              {{ ticket.user.name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
              {{ ticket.priority }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
              {{ ticket.status }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
              <Link :href="route('tickets.show', [ticket.id])"> View </Link>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :total-items="tickets.total"
        :current-page="tickets.current_page"
        :per-page="tickets.per_page"
        @update:currentPage="getTickets"
      />
    </div>
  </AuthenticatedLayout>
</template>

