<template>
  <div class="bg-white min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="flex justify-end items-center p-6">
      <Link :href="route('login')" class="text-gray-600 hover:text-gray-900 text-sm font-medium mr-4">
      Sign in
      </Link>
      <Link :href="route('register')"
        class="bg-gray-900 text-white text-sm font-medium py-2 px-4 rounded hover:bg-gray-700">
      Sign Up
      </Link>
    </nav>

    <!-- Hero Section -->
    <div class="flex-grow px-6 pt-12 h-screen">
      <div class="text-center">
        <!-- Placeholder Logo -->
        <div class="mb-6 flex justify-center">
          <AuthenticationCardLogo />
        </div>
        <!-- Bold Message -->
        <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900">
          Uptime monitoring sans the compromises
        </h1>
        <p class="mt-6 text-lg text-gray-600">
          An uptime monitoring solution by an indie hacker to overcome the many compromises in the existing solutions.
        </p>

        <!-- Compromises List -->
        <div class="mt-8 max-w-3xl flex justify-center mx-auto">
          <ul class="space-y-4 text-left">
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">Ridiculous 5 minute check frequency on free plans.</span>
            </li>
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">Ridiculous 1 minute check frequency even on most paid plans.</span>
            </li>
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">Pay more for status pages.</span>
            </li>
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">Pay more to add teammates.</span>
            </li>
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">Pay more to be notified.</span>
            </li>
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">Pay more for basic integrations.</span>
            </li>
            <li class="flex items-start">
              <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-gray-600">...and the list goes on.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Features Section -->
    <div class="bg-gray-50 py-12">
      <div class="max-w-6xl mx-auto px-6">
        <p class="text-2xl font-extrabold text-gray-900 text-center mb-12">
          The AppsAre difference
        </p>
        <p class="mt-6 text-2xl text-gray-600 mb-12 text-center">
          There are literally hundreds of uptime monitoring solutions out there. Some expensive and some seemingly free.
          I wanted to create a new one to overcome some compromises that I felt were unacceptable.
        </p>

        <!-- Feature 1 -->
        <div class="flex flex-col items-center justify-center py-16 bg-white shadow rounded-lg mb-12">
          <h3 class="text-3xl font-bold text-gray-900 mb-4">Default 30</h3>
          <p class="text-lg text-gray-600 text-center max-w-3xl">
            Free, cheap, or expensive, the default check frequency for an uptime service should be no more than 30
            seconds. After all, the point of an uptime monitoring service is to know when a service is affected and get
            it fixed as soon as possible. Now imagine knowing the service is down after 5 minutes.
          </p>
        </div>

        <!-- Feature 2 -->
        <div class="flex flex-col items-center justify-center py-16 bg-white shadow rounded-lg mb-12">
          <h3 class="text-3xl font-bold text-gray-900 mb-4">Truly indie hacker friendly service</h3>
          <p class="text-lg text-gray-600 text-center max-w-3xl">
            A cost-effective solution shouldn't make you compromise on the basics. That's why, even in our lowest plans,
            we include everything, limited only by the number of websites you're tracking. Our most basic plan includes
            30 second checks, unlimited status pages, unlimited team members, and unlimited integrations.
          </p>
        </div>

        <!-- Feature 3 -->
        <div class="flex flex-col items-center justify-center py-16 bg-white shadow rounded-lg mb-12">
          <h3 class="text-3xl font-bold text-gray-900 mb-4">Unlimited Status Pages</h3>
          <p class="text-lg text-gray-600 text-center max-w-3xl">
            Create one or 10 status pages with complete peace of mind that you won't be charged extra for it. Now and
            forever.
          </p>
        </div>

        <!-- Feature 4 -->
        <div class="flex flex-col items-center justify-center py-16 bg-white shadow rounded-lg mb-12">
          <h3 class="text-3xl font-bold text-gray-900 mb-4">Team Collaboration</h3>
          <p class="text-lg text-gray-600 text-center max-w-3xl">
            Want to add a couple more people to your team, maybe a contractor or a friend helping you out? No problem.
            We don't limit the number of people you can add to your team. You can add as many as you want, and they'll
            have access to all the features.
          </p>
        </div>

        <!-- Feature 5 -->
        <div class="flex flex-col items-center justify-center py-16 bg-white shadow rounded-lg mb-12">
          <h3 class="text-3xl font-bold text-gray-900 mb-4">Seamless Integrations</h3>
          <p class="text-lg text-gray-600 text-center max-w-3xl">
            Basecamp, Slack, and Pushover integrations are included. You can be notified of the status of your websites
            via Basecamp Campfire chat, Slack channels, SMS, or push notifications through Pushover.
          </p>
        </div>

        <!-- Feature 6 -->
        <div class="flex flex-col items-center justify-center py-16 bg-white shadow rounded-lg">
          <h3 class="text-3xl font-bold text-gray-900 mb-4">Got clients?</h3>
          <p class="text-lg text-gray-600 text-center max-w-3xl">
            For consultants and service companies with multiple clients, we have a unique team feature that lets you
            create multiple teams – one for every client. You can keep track of their websites inside each team and also
            invite them to join.
          </p>
        </div>
      </div>
    </div>
   <!-- Pricing Section -->
<div class="bg-white py-16">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-12">
      Choose Your Plan
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Indie Hacker Plan -->
      <div class="border border-gray-200 rounded-lg shadow-lg p-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Indie Hacker - The Dream</h3>
        <p class="text-lg text-gray-600 mb-6">
          Perfect for beginning your indie hacker journey.
        </p>
        <div class="mb-6">
          <p class="text-4xl font-extrabold text-gray-900">$5</p>
          <p class="text-sm text-gray-600">per month</p>
        </div>
        <ul class="space-y-4 text-gray-600">
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            30-second check frequency
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            10 trackers included
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Unlimited status pages
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Unlimited team members
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            All integrations
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Email, Slack, Basecamp notifications
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Purchase SMS and Call credits
          </li>
          <li class="flex items-start">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Multiple teams for clients
              </li>
        </ul>
        <button class="mt-6 w-full bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-700">
          Choose Plan
        </button>
      </div>

      <!-- Startup Plan -->
      <div class="border border-gray-200 rounded-lg shadow-lg p-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Indie Hacker - Realized</h3>
        <p class="text-lg text-gray-600 mb-6">
          Hit your revenue goals and growing your product.
        </p>
        <div class="mb-6">
          <p class="text-4xl font-extrabold text-gray-900">$15</p>
          <p class="text-sm text-gray-600">per month</p>
        </div>
        <ul class="space-y-4 text-gray-600">
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            30-second check frequency
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            50 trackers included
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Unlimited status pages
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Unlimited team members
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            All integrations
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Email, Slack, Basecamp notifications
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Purchase SMS and Call credits
          </li>
          <li class="flex items-start">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Multiple teams for clients
              </li>
        </ul>
        <button class="mt-6 w-full bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-700">
          Choose Plan
        </button>
      </div>

      <!-- Consultant Plan -->
      <div class="border border-gray-200 rounded-lg shadow-lg p-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Small Business</h3>
        <p class="text-lg text-gray-600 mb-6">
          Ideal for agencies and service providers with multiple clients.
        </p>
        <div class="mb-6">
          <p class="text-4xl font-extrabold text-gray-900">$30</p>
          <p class="text-sm text-gray-600">per month</p>
        </div>
        <ul class="space-y-4 text-gray-600">
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            30-second check frequency
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            100 trackers included
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Unlimited status pages
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Unlimited team members
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            All integrations
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Email, Slack, Basecamp notifications
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Purchase SMS and Call credits
          </li>
          <li class="flex items-start">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Multiple teams for clients
          </li>
        </ul>
        <button class="mt-6 w-full bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-700">
          Choose Plan
        </button>
      </div>
    </div>
  </div>
</div>



  </div>
</template>

<script setup>
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>