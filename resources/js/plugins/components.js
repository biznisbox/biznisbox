/**
 * Plugin for custom components used in application (path: resources/js/components/)
 */
import TextInput from '@/components/form/TextInput.vue'
import PasswordInput from '@/components/form/PasswordInput.vue'
import CountrySelect from '@/components/form/CountrySelect.vue'
import DateInput from '@/components/form/DateInput.vue'
import NumberInput from '@/components/form/NumberInput.vue'
import NumberingInput from '@/components/form/NumberingInput.vue'
import SelectButtonInput from '@/components/form/SelectButtonInput.vue'
import StarButton from '@/components/form/StarButton.vue'
import SelectInput from '@/components/form/SelectInput.vue'
import MultiSelectInput from '@/components/form/MultiSelectInput.vue'
import TextAreaInput from '@/components/form/TextAreaInput.vue'
import TreeSelectInput from '@/components/form/TreeSelectInput.vue'
import TinyMceEditor from '@/components/form/TinyMceEditor.vue'
import SideMenu from '@/components/SideMenu.vue'
import PageHeader from '@/components/PageHeader.vue'
import DisplayData from '@/components/DisplayData.vue'
import LoadingScreen from '@/components/LoadingScreen.vue'
import OtpInput from '@/components/form/OtpInput.vue'
import AuditLog from '@/components/AuditLog.vue'
import PdfViewer from '@/components/PdfViewer.vue'
import DashboardCardWithIcon from '@/components/dashboard/DashboardCardWithIcon.vue'

export default {
    install(app) {
        app.component('TextInput', TextInput)
        app.component('PasswordInput', PasswordInput)
        app.component('CountrySelect', CountrySelect)
        app.component('DateInput', DateInput)
        app.component('NumberInput', NumberInput)
        app.component('SelectButtonInput', SelectButtonInput)
        app.component('StarButton', StarButton)
        app.component('SelectInput', SelectInput)
        app.component('TreeSelectInput', TreeSelectInput)
        app.component('TextAreaInput', TextAreaInput)
        app.component('TinyMceEditor', TinyMceEditor)
        app.component('SideMenu', SideMenu)
        app.component('PageHeader', PageHeader)
        app.component('DisplayData', DisplayData)
        app.component('LoadingScreen', LoadingScreen)
        app.component('NumberingInput', NumberingInput)
        app.component('OtpInput', OtpInput)
        app.component('AuditLog', AuditLog)
        app.component('MultiSelectInput', MultiSelectInput)
        app.component('PdfViewer', PdfViewer)
        app.component('DashboardCardWithIcon', DashboardCardWithIcon)
    },
}
