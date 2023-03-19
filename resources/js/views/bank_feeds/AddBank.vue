<template>
    <user-layout>
        <user-header :title="$t('open_banking.connect_new_account')">
            <template #actions>
                <Button :label="$t('basic.cancel')" icon="fa fa-times" class="p-button-danger" @click="cancelNavigation" />
            </template>
        </user-header>

        <div v-if="step == 1" id="select_country">
            <LoadingScreen :blocked="loadingData">
                <DataView :value="available_countries" class="w-full">
                    <template #list="slotProps">
                        <div class="col-12 my-2 grid" @click="selectCountry(slotProps.data.code)">
                            <div class="flex align-content-center flex-wrap">
                                <span :class="`fi fi-${slotProps.data?.code.toLowerCase()} flag-icon flex`"></span>
                                <span class="flex ml-5">{{ slotProps.data.name }}</span>
                            </div>
                        </div>
                    </template>
                </DataView>
            </LoadingScreen>
        </div>

        <div v-if="step == 2" id="select_bank">
            <LoadingScreen :blocked="loadingData">
                <DataView :value="banks" class="w-full">
                    <template #list="slotProps">
                        <div class="col-12 my-2 grid" @click="selectBank(slotProps.data.id)">
                            <div class="flex align-content-center flex-wrap">
                                <Avatar :image="slotProps.data.logo" size="large" class="flex mr-5" />
                                <span class="flex ml-5">{{ slotProps.data.name }}</span>
                            </div>
                        </div>
                    </template>
                </DataView>
            </LoadingScreen>
        </div>
    </user-layout>
</template>

<script>
import OpenBankingMixin from '@/mixins/open_banking'
import open_banking_countries from '@/data/open_banking_countries.json'
export default {
    name: 'BankFeedsAddBank',
    mixins: [OpenBankingMixin],
    data() {
        return {
            available_countries: open_banking_countries,
            selected_country: null,
            step: 1, // Step 1: Select country (default) | Step 2: Select bank
        }
    },

    created() {
        if (this.$route.query.step && this.selected_country) {
            this.step = this.$route.query.step
        }

        if (this.$route.query.ref) {
            this.step = 3
            this.getRequisitions(this.$route.query.ref)
        }
    },

    methods: {
        selectCountry(country_code) {
            this.selected_country = country_code
            this.getBanks(country_code)
            this.$router.push({ query: { step: 2 } })
            this.step = 2
        },

        selectBank(bank_id) {
            this.initSession(bank_id)
        },

        cancelNavigation() {
            this.$router.push({ name: 'open-banking' })
        },
    },
}
</script>

<style>
.flag-icon {
    width: 50px;
    height: 50px;
}
</style>
