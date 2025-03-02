<template>
    <div class="container w-full md:w-1/2 mx-auto p-6">
        <div class="card">
            <h1 class="text-2xl font-bold text-center">{{ $t('install.welcome_message') }}</h1>

            <p class="text-center">{{ $t('install.requirements_message') }}</p>

            <div class="mt-6">
                <SelectInput v-model="language" :label="$t('form.language')" :options="locales" optionLabel="label" optionValue="value" />

                <LoadingScreen :blocked="loadingData">
                    <ul>
                        <li v-for="requirement in requirements" :key="requirement.name">
                            <span v-if="requirement.status" class="text-green-500">&#10003;</span>
                            <span v-else class="text-red-500">&#10005;</span>
                            {{ $t(`install.requirements.${requirement.name}`) }}
                        </li>
                    </ul>
                </LoadingScreen>
            </div>

            <div class="mt-6">
                <p v-if="allRequirementsMet" class="text-green-500">{{ $t('install.all_requirements_met') }}</p>
                <p v-else class="text-red-500">{{ $t('install.not_all_requirements_met') }}</p>
            </div>

            <div class="flex justify-end mt-6">
                <Button @click="nextStep" :disabled="!allRequirementsMet" :label="$t('basic.next')" icon="fas fa-arrow-right" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'InstallRequirementsPage',

    data() {
        return {
            requirements: [],
            allRequirementsMet: false,
            locales: [
                //  List of available languages -> update on adding new languages
                { value: 'en', label: 'English' },
                { value: 'de', label: 'Deutsch' },
                { value: 'sl', label: 'Slovenščina' },
                { value: 'es', label: 'Español' },
                { value: 'fr', label: 'Français' },
                { value: 'it', label: 'Italiano' },
                { value: 'nl', label: 'Nederlands' },
                { value: 'pl', label: 'Polski' },
                { value: 'pt', label: 'Português' },
                { value: 'ru', label: 'Русский' },
                { value: 'tr', label: 'Türkçe' },
                { value: 'zh', label: '中文' },
                { value: 'no', label: 'Norwegian' },
                { value: 'da', label: 'Danish' },
                { value: 'sv', label: 'Swedish' },
                { value: 'fi', label: 'Finnish' },
            ],
            language: 'en',
        }
    },

    methods: {
        getRequirements() {
            this.makeHttpRequest('GET', `/api/install/check-requirements`)
                .then((response) => {
                    let data = response.data.data
                    Object.keys(data).forEach((key) => {
                        // Check if the key is php_extensions and loop through the extensions to add them to the requirements array
                        if (key == 'php_extensions') {
                            Object.keys(data[key]).forEach((extension) => {
                                this.requirements.push({
                                    name: extension,
                                    status: data[key][extension],
                                })
                            })
                        } else {
                            this.requirements.push({
                                name: key,
                                status: data[key],
                            })
                        }
                    })
                    this.checkIfAllRequirementsAreMet()
                })
                .catch((error) => {
                    console.log(error)
                })
        },

        checkIfAllRequirementsAreMet() {
            this.allRequirementsMet = this.requirements.every((requirement) => requirement.status)
        },

        nextStep() {
            if (this.allRequirementsMet) {
                this.$cookies.set('lang', this.language)
                this.$router.push({ name: 'install-database' })
            }
        },
    },

    created() {
        document.title = this.$t('install.installation')
        if (this.$cookies.get('lang')) {
            this.language = this.$cookies.get('lang')
        }
        else {
            this.$cookies.set('lang', "en") // fix for the first time when the cookie is not set
            this.language = "en"
        }
        this.$i18n.locale = this.language // Set the language to the selected language (default is English)
        this.checkIfInstalled()
        this.getRequirements()
    },

    watch: {
        language() {
            this.$cookies.set('lang', this.language)
            this.$i18n.locale = this.language
        },
    },
}
</script>
