/**
 * Plugin for custom components used in application.
 */
import TextInput from '@/components/form/TextInput.vue'
import NumberInput from '@/components/form/NumberInput.vue'
import SelectButtonInput from '@/components/form/SelectButtonInput.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import TextAreaInput from '@/components/form/TextAreaInput.vue'
import DateInput from '@/components/form/DateInput.vue'
import PasswordInput from '@/components/form/PasswordInput.vue'
import CountrySelect from '@/components/form/CountrySelect.vue'
import HeaderActionButton from '@/components/HeaderActionButton.vue'
import LoadingScreen from '@/components/LoadingScreen.vue'
import DisplayData from '@/components/DisplayData.vue'
import DashboardCard from '@/components/DashboardCard.vue'
import TinyMceEditor from '@/components/form/TinyMceEditor.vue'
import StarButton from '@/components/form/StarButton.vue'
export default {
    install(app) {
        app.component('TextInput', TextInput)
        app.component('NumberInput', NumberInput)
        app.component('SelectButtonInput', SelectButtonInput)
        app.component('SelectInput', SelectInput)
        app.component('TextAreaInput', TextAreaInput)
        app.component('DateInput', DateInput)
        app.component('PasswordInput', PasswordInput)
        app.component('CountrySelect', CountrySelect)
        app.component('TinyMceEditor', TinyMceEditor)

        // Custom components
        app.component('HeaderActionButton', HeaderActionButton)
        app.component('LoadingScreen', LoadingScreen)
        app.component('DisplayData', DisplayData)
        app.component('DashboardCard', DashboardCard)
        app.component('StarButton', StarButton)
    },
}
