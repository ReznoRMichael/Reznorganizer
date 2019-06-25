<template>
    <div class="flex items-center justify-between mb-3 md:mr-6 md:mb-0">

        <button v-for="(color, theme) in themes" :key="theme"
            class="rounded-full w-5 h-5 bg-default border mx-1 focus:outline-none"
            :class="{ 'border-accent' : selectedTheme == theme }"
            :style="{ backgroundColor: color }"
            title="Switch theme"
            @click="selectedTheme = theme">
        </button>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                themes: {
                    'theme-light': '#edf2f7',
                    'theme-dark': '#333333'
                },
                selectedTheme: 'theme-light'
            };
        },

        // watcher for preserving the selected theme across the page (from local storage)
        created() {
            this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
        },

        watch: {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);
                // a local database for preserving the current selected theme
                localStorage.setItem('theme', this.selectedTheme);
            }
        }
    }
</script>
