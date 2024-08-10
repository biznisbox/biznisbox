import PrimeVue from 'primevue/config'
import biznisbox from '@/presets'

import AutoComplete from 'primevue/autocomplete'
import CascadeSelect from 'primevue/cascadeselect'
import Checkbox from 'primevue/checkbox'
import ColorPicker from 'primevue/colorpicker'
import Select from 'primevue/select'
import IconField from 'primevue/iconfield'
import InputIcon from 'primevue/inputicon'
import InputGroup from 'primevue/inputgroup'
import InputGroupAddon from 'primevue/inputgroupaddon'
import InputOtp from 'primevue/inputotp'
import InputNumber from 'primevue/inputnumber'
import InputMask from 'primevue/inputmask'
import InputText from 'primevue/inputtext'
import Knob from 'primevue/knob'
import Listbox from 'primevue/listbox'
import MultiSelect from 'primevue/multiselect'
import Password from 'primevue/password'
import RadioButton from 'primevue/radiobutton'
import Rating from 'primevue/rating'
import SelectButton from 'primevue/selectbutton'
import Slider from 'primevue/slider'
import Textarea from 'primevue/textarea'
import ToggleButton from 'primevue/togglebutton'
import TreeSelect from 'primevue/treeselect'
import Button from 'primevue/button'
import SpeedDial from 'primevue/speeddial'
import SplitButton from 'primevue/splitbutton'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import ColumnGroup from 'primevue/columngroup'
import Row from 'primevue/row'
import Timeline from 'primevue/timeline'
import Tree from 'primevue/tree'
import TreeTable from 'primevue/treetable'
import Card from 'primevue/card'
import FileUpload from 'primevue/fileupload'
import ContextMenu from 'primevue/contextmenu'
import Menu from 'primevue/menu'
import ConfirmDialog from 'primevue/confirmdialog'
import ConfirmationService from 'primevue/confirmationservice'
import ConfirmPopup from 'primevue/confirmpopup'
import Dialog from 'primevue/dialog'
import Drawer from 'primevue/drawer'
import Toast from 'primevue/toast'
import ToastService from 'primevue/toastservice'
import Badge from 'primevue/badge'
import BadgeDirective from 'primevue/badgedirective'
import ScrollTop from 'primevue/scrolltop'
import ProgressSpinner from 'primevue/progressspinner'
import ProgressBar from 'primevue/progressbar'
import Toolbar from 'primevue/toolbar'
import Avatar from 'primevue/avatar'
import Tag from 'primevue/tag'
import BlockUI from 'primevue/blockui'
import Popover from 'primevue/popover'
import Tooltip from 'primevue/tooltip'
import Message from 'primevue/message'
import DatePicker from 'primevue/datepicker'
import Tabs from 'primevue/tabs'
import TabList from 'primevue/tablist'
import Tab from 'primevue/tab'
import TabPanels from 'primevue/tabpanels'
import TabPanel from 'primevue/tabpanel'
import ToggleSwitch from 'primevue/toggleswitch'

export default {
    install(app) {
        app.use(PrimeVue, {
            unstyled: true,
            pt: biznisbox,
        })
        app.use(ConfirmationService)
        app.use(ToastService)
        app.component('AutoComplete', AutoComplete)
        app.component('CascadeSelect', CascadeSelect)
        app.component('Checkbox', Checkbox)
        app.component('ColorPicker', ColorPicker)
        app.component('IconField', IconField)
        app.component('InputIcon', InputIcon)
        app.component('InputGroup', InputGroup)
        app.component('InputGroupAddon', InputGroupAddon)
        app.component('InputOtp', InputOtp)
        app.component('InputNumber', InputNumber)
        app.component('InputMask', InputMask)
        app.component('InputText', InputText)
        app.component('Knob', Knob)
        app.component('Listbox', Listbox)
        app.component('MultiSelect', MultiSelect)
        app.component('Password', Password)
        app.component('RadioButton', RadioButton)
        app.component('Rating', Rating)
        app.component('SelectButton', SelectButton)
        app.component('Slider', Slider)
        app.component('Textarea', Textarea)
        app.component('ToggleButton', ToggleButton)
        app.component('TreeSelect', TreeSelect)
        app.component('Button', Button)
        app.component('SpeedDial', SpeedDial)
        app.component('SplitButton', SplitButton)
        app.component('DataTable', DataTable)
        app.component('Column', Column)
        app.component('ColumnGroup', ColumnGroup)
        app.component('Row', Row)
        app.component('Timeline', Timeline)
        app.component('Tree', Tree)
        app.component('TreeTable', TreeTable)
        app.component('Card', Card)
        app.component('FileUpload', FileUpload)
        app.component('ContextMenu', ContextMenu)
        app.component('Menu', Menu)
        app.component('ConfirmDialog', ConfirmDialog)
        app.component('ConfirmPopup', ConfirmPopup)
        app.component('Dialog', Dialog)
        app.component('Drawer', Drawer)
        app.component('Toast', Toast)
        app.component('Badge', Badge)
        app.directive('badge', BadgeDirective)
        app.component('ScrollTop', ScrollTop)
        app.component('ProgressSpinner', ProgressSpinner)
        app.component('ProgressBar', ProgressBar)
        app.component('Toolbar', Toolbar)
        app.component('Avatar', Avatar)
        app.component('Tag', Tag)
        app.component('BlockUI', BlockUI)
        app.component('Message', Message)
        app.directive('tooltip', Tooltip)
        app.directive('Popover', Popover)
        app.component('DatePicker', DatePicker)
        app.component('Select', Select)
        app.component('Tabs', Tabs)
        app.component('TabList', TabList)
        app.component('Tab', Tab)
        app.component('TabPanels', TabPanels)
        app.component('TabPanel', TabPanel)
        app.component('ToggleSwitch', ToggleSwitch)
    },
}
