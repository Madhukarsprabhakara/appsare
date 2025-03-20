<template>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Status Page Name -->
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ statusPage.name }}</h1>

       
                  <div v-for="action in actions" :key="action.name" class="bg-white flex justify-center items-center">
                    <div>
                        
                      <!-- <span :class="[action.iconBackground, action.iconForeground, 'inline-flex rounded-lg p-3 ring-4 ring-white']">
                        <component :is="action.icon" class="size-6" aria-hidden="true" />
                      </span> -->
                    </div>
                    <div class="mt-8 border-b-2 pb-4 border-gray-100">
                      <h3 class="text-md mb-2 font-medium">
                        <a :href="action.href" class="focus:outline-none">
                          <!-- Extend touch target to entire panel -->
                          
                          {{ action.url }}
                        </a>
                      </h3>
                      <UptimeIndicator />
                      <!-- <p class="mt-2 text-sm text-gray-500">Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.</p> -->
                    </div>
                    
                    <!-- <span class="pointer-events-none absolute right-6 top-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
                      <svg class="size-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                      </svg>
                    </span> -->
                  </div>
                

        <!-- No Trackers Message -->
        
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import UptimeIndicator from '@/Components/UptimeIndicator.vue';
// Access the props passed from the backend
const { props } = usePage();
const statusPage = props.statusPage;
const trackers = props.trackers;

  import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Popover,
    PopoverButton,
    PopoverOverlay,
    PopoverPanel,
    TransitionChild,
    TransitionRoot,
  } from '@headlessui/vue'
  import {
    AcademicCapIcon,
    BanknotesIcon,
    Bars3Icon,
    BellIcon,
    CheckBadgeIcon,
    ClockIcon,
    ReceiptRefundIcon,
    UsersIcon,
    XMarkIcon,
  } from '@heroicons/vue/24/outline'
  import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
  
  const user = {
    name: 'Chelsea Hagon',
    email: 'chelsea.hagon@example.com',
    role: 'Human Resources Manager',
    imageUrl:
      'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
  }
  const navigation = [
    { name: 'Home', href: '#', current: true },
    { name: 'Profile', href: '#', current: false },
    { name: 'Resources', href: '#', current: false },
    { name: 'Company Directory', href: '#', current: false },
    { name: 'Openings', href: '#', current: false },
  ]
  const userNavigation = [
    { name: 'Your Profile', href: '#' },
    { name: 'Settings', href: '#' },
    { name: 'Sign out', href: '#' },
  ]
  const stats = [
    { id: 1, value: 'All "AppsAre" Operational' },
    
  ]
  const actions = props.trackers
  const recentHires = [
    {
      name: 'Leonard Krasner',
      handle: 'leonardkrasner',
      imageUrl:
        'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      href: '#',
    },
    {
      name: 'Floyd Miles',
      handle: 'floydmiles',
      imageUrl:
        'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      href: '#',
    },
    {
      name: 'Emily Selman',
      handle: 'emilyselman',
      imageUrl:
        'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      href: '#',
    },
    {
      name: 'Kristin Watson',
      handle: 'kristinwatson',
      imageUrl:
        'https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      href: '#',
    },
  ]
  const announcements = [
    {
      id: 1,
      title: 'Office closed on July 2nd',
      href: '#',
      preview:
        'Cum qui rem deleniti. Suscipit in dolor veritatis sequi aut. Vero ut earum quis deleniti. Ut a sunt eum cum ut repudiandae possimus. Nihil ex tempora neque cum consectetur dolores.',
    },
    {
      id: 2,
      title: 'New password policy',
      href: '#',
      preview:
        'Alias inventore ut autem optio voluptas et repellendus. Facere totam quaerat quam quo laudantium cumque eaque excepturi vel. Accusamus maxime ipsam reprehenderit rerum id repellendus rerum. Culpa cum vel natus. Est sit autem mollitia.',
    },
    {
      id: 3,
      title: 'Office closed on July 2nd',
      href: '#',
      preview:
        'Tenetur libero voluptatem rerum occaecati qui est molestiae exercitationem. Voluptate quisquam iure assumenda consequatur ex et recusandae. Alias consectetur voluptatibus. Accusamus a ab dicta et. Consequatur quis dignissimos voluptatem nisi.',
    },
  ]
</script>