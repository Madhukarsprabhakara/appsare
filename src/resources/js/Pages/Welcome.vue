<template>
  <div class="bg-white min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="flex justify-end items-center p-6">
      <Link :href="route('login')" class="text-gray-600 hover:text-gray-900 text-sm font-medium mr-4">
        Login
      </Link>
      <Link
        :href="route('register')"
        class="bg-gray-900 text-white text-sm font-medium py-2 px-4 rounded hover:bg-gray-700"
      >
        Sign Up
      </Link>
    </nav>

    <!-- Hero Section -->
    <div class="flex-grow px-6 pt-12">
      <div class="text-center">
        <!-- Placeholder Logo -->
        <div class="mb-6 flex justify-center">
          <AuthenticationCardLogo />
        </div>
        <!-- Bold Message -->
        <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900">
          Uptime monitoring sans compromise
        </h1>
        <p class="mt-4 text-lg text-gray-600">
          The compromises we see in present uptime monitoring solutions.
        </p>

        <!-- Compromises List -->
        <div class="mt-8 max-w-3xl flex justify-center mx-auto">
          <ul class="space-y-4 text-left">
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">Ridiculous 5 minute frequency checks on free plans.</span>
            </li>
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">Most paid plans come with 1 minute frequency checks.</span>
            </li>
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">Pay more for status pages.</span>
            </li>
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">Pay more to add teammates.</span>
            </li>
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">Pay more to be notified.</span>
            </li>
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">Pay more for basic integrations.</span>
            </li>
            <li class="flex items-start">
              <svg
                class="w-6 h-6 text-red-500 flex-shrink-0 mr-3"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
              <span class="text-gray-600">...and the list goes on.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- features begin-->
     
  </div>
</template>

<script setup>
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>