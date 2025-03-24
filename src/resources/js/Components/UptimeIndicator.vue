<template>
  <div class="flex space-x-1">
    <!-- Render bars for the last 60 days -->
    <div v-for="(day, index) in last60Days" :key="index"
      v-tooltip="`${day.day} ${day.uptime_percentage !== null ? day.uptime_percentage + '%' : 'No Data'}`"
      :class="getBarClass(day.uptime_percentage)" class="h-7 w-1 rounded-md"></div>
  </div>
</template>

<script setup>
import { computed, defineProps } from 'vue';
import dayjs from 'dayjs';
import dayjsPluginUTC from 'dayjs-plugin-utc'
 
dayjs.extend(dayjsPluginUTC)
// Accept uptime_data as a prop
const props = defineProps({
  uptime_data: {
    type: Array,
    required: true,
  },
});

// Generate the last 60 days and merge with uptime_data
const last60Days = computed(() => {
  const today = dayjs();
  const days = [];

  // Generate the last 60 days
  for (let i = 59; i >= 0; i--) {
    const date = today.subtract(i, 'day').format('YYYY-MM-DD');
    days.push({
      dayo: date,
      uptime_percentage: null, // Default to null for no data
    });
  }

  // console.log('Generated last60Days:', days);
  
  
 
  // Merge uptime_data into the last 60 days
  // Merge uptime_data into the last 60 days
  return days.map((day) => {
    const matchingData = props.uptime_data.find((data) => {
      const daym = dayjs(data.day);
      
      
      const normalizedDay = daym.utcOffset(420).format('YYYY-MM-DD'); // Normalize the day format
      
      return normalizedDay === day.dayo;
    });

    if (matchingData) {
      
      return {
        ...matchingData,
        day: day.dayo, // Ensure the day is in normalized format
      };
    }

    
    return {
      day: day.dayo, // Explicitly set the day field for default days
      uptime_percentage: null, // Keep uptime_percentage as null for no data
    }; // Return the default day object if no matching data is found
  });
});

// Function to determine the bar color based on uptime_percentage
const getBarClass = (uptime_percentage) => {
  if (uptime_percentage === null) {
    return 'bg-gray-500 hover:bg-gray-400'; // Gray for no data
  }  else if (uptime_percentage === 100) {
    return 'bg-green-500 hover:bg-green-400'; // Dark green for high uptime
  } else if (uptime_percentage >= 99) {
    return 'bg-green-300 hover:bg-green-200'; // Lighter green for high uptime
  } else if (uptime_percentage >= 97) {
    return 'bg-orange-500 hover:bg-orange-400'; // Orange for degraded uptime
  } else {
    return 'bg-red-500 hover:bg-red-400'; // Red for low uptime
  }
};
</script>