<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
            <router-link v-bind:to="{ name: 'bookables' }" class="navbar-brand mr-auto">Larave Vue</router-link>
        </nav>
        <div class="container mt-4 mb-4 pr-4 pl-4"></div>
        <router-view></router-view>
    </div>
</template>
